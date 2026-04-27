@extends('layouts.template')
<style>
    td[colspan="6"] {
        padding: 0px !important;
        padding-left: 44px !important;
    }

    table.dataTable td.dt-control:before{
        margin-top: none !important;
    }
</style>
@section('title','Cetak Penyerahan Berkas')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Cetak Penyerahan Berkas</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pemberkasan</li>
                    <li class="breadcrumb-item active">Cetak Penyerahan Berkas</li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <form id="formContract" action="{{route('files.print.submission')}}" method="post">
                    <button type="button" class="btn btn-success btn-sm btn-print-si"><i class='fa fa-print'></i>&nbsp;Print</button>
                    @csrf()
                    <table id="dataTable" class="table table-bordered table-striped table-hover" width="100%">
                        <thead>
                            <tr>
                                <th width="5px"></th>
                                <th width="10px">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="all_bank" name="all_bank" class="bank-check-all">
                                        <label for="all_bank"></label>
                                    </div>
                                </th>
                                <th width="10px">No</th>
                                <th>Nama Bank</th>
                                <th>Jumlah Debitur</th>
                                <th>Plafon</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
@endsection
@push('script')
    <script>
        $(function () {
            getData()
        })

        function getData(){
            var employeeDT = $('#dataTable').DataTable({
                processing: true,
                searching: false,
                lengthChange: false,
                serverSide: true,
                filter: true,
                ajax: {
                    url: "{!! route('files.submission.datatable') !!}",
                    type: 'GET'
                },
                columns: [
                    {
                        className: 'dt-control',
                        orderable: false,
                        searchable: false,
                        data: null,
                        defaultContent: ''
                    },
                    { data: 'checkbox', name: 'checkbox', searchable: false, orderable: false},
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: 'name', name: 'name', searchable: false, orderable: false},
                    { data: 'debitur', name: 'debitur', searchable: false, orderable: false},
                    { data: 'plafond', name: 'plafond', searchable: false, orderable: false}
                ]
            });
        }

        $('#dataTable tbody').on('click', 'td.dt-control', function () {
            var tr = $(this).closest('tr');
            var row = $('#dataTable').DataTable().row(tr);
            if (row.child.isShown()) {
                row.child.hide();
            }
            else {
                row.child(expandRow(row.data())).show();
            }
        });

        function expandRow(data) {
            var application = JSON.parse(data.data)
            var tbBody = '';
            $.each(application, function(key, value) {
                tbBody +=`<tr>
                            <td><div class="icheck-primary d-inline">
                                    <input type="checkbox" class="si-check application-check application_${data.id} bank_${data.id}" id="application_${value.id}" name="applications[${data.id}][${value.id}]" data-bank="${data.id}">
                                    <label for="application_${value.id}"></label>
                                </div></td>
                            <td>${value.branch_unit_name}</td>
                            <td>${value.nopen}</td>
                            <td>${value.name}</td>
                            <td>${value.contract_date}</td>
                            <td>${value.contract_number}</td>
                            <td>${value.product_name}</td>
                            <td>${value.finance_type}</td>
                            <td>${value.tenor}</td>
                            <td>${value.plafond}</td>
                        </tr>`
            });

            var dt = `<table class="table table-bordered table-striped table-hover" width="100%"  style="margin-bottom:0px;">
                        <tr>
                            <th width="10"></th>
                            <th>Unit Pelayanan</th>
                            <th>Nopen</th>
                            <th>Nama Pemohon</th>
                            <th>Tanggal Akad</th>
                            <th>No Akad</th>
                            <th>Produk Pembiayaan</th>
                            <th>Jenis Pembiayaan</th>
                            <th>Tenor</th>
                            <th>Plafond</th>
                        </tr>
                    ${tbBody}
                </table>`
            return dt;
        }

        function reloadDataTable(){
            var startDate = $('#start_date').val() || ''
            var endDate = $('#end_date').val() || ''
            var status = $('#status').val() || ''
            var group = $('#group').val() || ''
            var bank = $('#bank').val() || ''
            var params = new URLSearchParams({
                'start_date': startDate,
                'end_date': endDate,
                'status': status,
                'group': group,
                'bank': bank
            });
            $('#dataTable').DataTable().ajax.url("{!! route('files.submission.datatable') !!}?"+params.toString()).load();
        }

        $(document).on('click', '.bank-check-all', function(event) {
            var checkAll = $('.bank-check-all:checked').length;
            var checked = checkAll>0 ? true:false;
            $('.bank-check').attr('checked', checked)
            $('.si-check').attr('checked', checked)
        });

        $(document).on('click', '.bank-check', function(event) {
            var data =$(this).data()
            var totalChecked = $('#bank_'+data.id+':checked').length;
            var checked = totalChecked>0 ? true:false;
            $('.bank_'+data.id).attr('checked', checked)
        });

        $(document).on('click', '.application-check', function(event) {
            var data =$(this).data()
            var totalChecked = $('.bank_'+data.bank+':checked').length;
            if(totalChecked>0){
                $('#bank_'+data.bank).attr('checked', true)
            }else{
                $('#bank_'+data.bank).attr('checked', false)
            }
        });

        $(document).on('click', '.btn-print-si', function(event) {
            var totalDebitur = $('.application-check:checked').length;
            var contractNumber = ``
            Swal.fire({
                title: "CETAK PENYERAHAN BERKAS",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "<i class='fa fa-print'></i>&nbsp;Cetak",
                cancelButtonText: "<i class='fa fa-times'></i>&nbsp;Batal",
                reverseButtons: true,
                didOpen: function() {
                    $('#datetimepicker').datetimepicker({
                        format: 'DD-MM-YYYY',
                    })

                    $('#datetimepicker').on('change.datetimepicker', function(e){
                        contractNumber = `/SURAT-BERKAS/KPF/${moment(e.date).format("DDMMYYYY")}`;
                        $('#contract_number').val(contractNumber);
                        $('#contract_number').attr('readonly',false);
                    })
                },
                preConfirm: () => {
                    let result ={
                        contract_date: document.getElementById("contract_date").value,
                        contract_number: document.getElementById("contract_number").value,
                        debitur: document.getElementById("debitur").value,
                    }
                    return result
                },
                html:`
                    <div class="form-group required text-left">
                        <label class="control-label">Tanggal Cetak</label>
                        <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                            <input class="form-control datetimepicker-input" data-target="#datetimepicker" type="text" name="contract_date" id="contract_date">
                            <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group required  text-left">
                        <label class="control-label">Nomor Surat</label>
                        <input id="contract_number" class="form-control" readonly value="${contractNumber}">
                    </div>
                    <div class="form-group required  text-left">
                        <label class="control-label">Jumlah Debitur</label>
                        <input id="debitur" class="form-control" readonly value="${totalDebitur}">
                    </div>
                `
            }).then((result) => {
                console.log('RESULT', result);
                if (result.isConfirmed) {
                    printContract(result.value)
                }
            });
        });

        function printContract(values){
            var form = document.getElementById('formContract');
            var formData = new FormData(form)
            formData.append('date', values.contract_date)
            formData.append('number', values.contract_number)
            $.ajax({
                url: "{{route('files.print.submission')}}",
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                success:function(response){
                    reloadDataTable()
                }
            });
        }

    </script>
@endpush
