@extends('layouts.template')
@section('title','Monitoring Pembiayaan')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Monitoring Pembiayaan</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pengajuan</li>
                    <li class="breadcrumb-item active">Monitoring Pembiayaan</li>
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
                <input type="hidden" class="form-control float-right" id="start_date">
                <input type="hidden" class="form-control float-right" id="end_date">
                <table id="dataTable" class="table table-bordered table-striped table-hover" width="100%">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Tanggal Pengajuan</th>
                            <th rowspan="2">No Pensiun</th>
                            <th rowspan="2">Nama Pemohon</th>
                            <th rowspan="2">Sumber Dana</th>
                            <th rowspan="2">Produk Pembiayaan</th>
                            <th rowspan="2">Jenis Pembiayaan</th>
                            <th rowspan="2">Tenor</th>
                            <th rowspan="2">Plafon</th>
                            <th rowspan="2">Angsuran</th>
                            <th colspan="2"  class="text-center bg-success">Akad</th>
                            <th colspan="4"  class="text-center bg-success">Informasi Slik</th>
                            <th colspan="4"  class="text-center bg-primary">Informasi Verifikasi</th>
                            <th colspan="4"  class="text-center bg-info">Informasi Approval</th>
                            <th colspan="2"  class="text-center bg-info">Informasi Pencairan</th>
                            <th rowspan="2">Aksi</th>
                        </tr>
                        <tr>
                            <th class="text-center">Cetak</th>
                            <th class="text-center">Lihat</th>
                            <th class="text-center bg-success">Status</th>
                            <th class="bg-success">Keterangan</th>
                            <th class="bg-success">Diperiksa Oleh</th>
                            <th class="bg-success">Tanggal Periksa</th>
                            <th class="text-center bg-primary">Status</th>
                            <th class="bg-primary">Keterangan</th>
                            <th class="bg-primary">Diperiksa Oleh</th>
                            <th class="bg-primary">Tanggal Periksa</th>
                            <th class="text-center bg-info">Status</th>
                            <th class="bg-info">Keterangan</th>
                            <th class="bg-info">Diperiksa Oleh</th>
                            <th class="bg-info">Tanggal Periksa</th>
                            <th class="text-center bg-info">Status</th>
                            <th class="bg-info">Tanggal Pencairan</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
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
        var banks = @json($banks);
        $(function () {
            $('#datetimepicker1').datetimepicker({
                        useCurrent: false,
                        format: 'MM/DD/YYYY, HH:mm',
                        sideBySide: true,
                        date: '12/18/2018 18:30',
                        allowInputToggle: true
                    })
            getData()

            let bankOption = '';
            bankOption+=`<option value="">Semua</option>`
            $.each(banks, function(key, value) {
                bankOption+=`<option value="${value.id}">${value.name}</option>`
            });

            $('#dataTable_length').append(`
                <label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="text" class="custom-select custom-select-sm form-control form-control-sm float-right" id="daterange" aria-controls="dataTable">
                    </div>
                </label>
                <label>
                    <select class="custom-select custom-select-sm form-control form-control-sm" id="status" placeholder="Status" aria-controls="dataTable">
                        <option value="" selected>Semua</option>
                        <option value="queue">Antri</option>
                        <option value="on process">Diproses</option>
                        <option value="reject">Dibatalkan</option>
                        <option value="approve">Disetujui</option>
                    </select>
                </label>
                <label>
                    <select class="custom-select custom-select-sm form-control form-control-sm" id="group" placeholder="Group" aria-controls="dataTable">
                        <option value="express">Express</option>
                        <option value="regular">Reguler</option>
                    </select>
                </label>
                <label>
                    <select class="custom-select custom-select-sm form-control form-control-sm" id="bank" placeholder="Group" aria-controls="dataTable">
                        ${bankOption}
                    </select>
                </label>
            `)
            $('#dataTable_length').parent().removeClass('col-md-6').addClass('col-md-8')
            $('#dataTable_filter').parent().removeClass('col-md-6').addClass('col-md-4')
            $('#daterange').daterangepicker({
                autoApply:true
            })
            $('#daterange').on('apply.daterangepicker', function(ev, e) {
                var startDate = e.startDate.format('YYYY-MM-DD')
                var endDate = e.endDate.format('YYYY-MM-DD')
                $('#start_date').val(startDate)
                $('#end_date').val(endDate)
                reloadDataTable()
            });

            $('#bank').change(function() {
                reloadDataTable()
            });
            $('#status').change(function() {
                reloadDataTable()
            });
            $('#group').change(function() {
                reloadDataTable()
            });
        })


        $(document).on('click', '.print-contract', function(event) {
            let data = $(this).data();
            Swal.fire({
                title: "Cetak Akad",
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
                        var contractNumber = `${data.number}${moment(e.date).format("DDMMYYYY")}`;
                        $('#contract_number').val(contractNumber);
                        $('#contract_number').attr('readonly',false);
                    })
                },
                preConfirm: () => {
                    let result ={
                        contract_date: document.getElementById("contract_date").value,
                        contract_number: document.getElementById("contract_number").value,
                        interest_type: document.getElementById("interest_type").value,
                        interest: document.getElementById("interest").value,
                        id: document.getElementById("id").value,
                        url: document.getElementById("url").value,
                    }
                    return result
                },
                html:`
                    <input type="hidden" id="url" class="form-control" value="${data.url}">
                    <input type="hidden" id="id" class="form-control" value="${data.id}">
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
                        <label class="control-label">Nomor Akad</label>
                        <input id="contract_number" class="form-control" readonly value="">
                    </div>
                    <div class="form-group required  text-left">
                        <label class="control-label">Produk Pembiayaan</label>
                        <input id="finance_product" class="form-control" readonly value="${data.product_name}">
                    </div>
                    <div class="form-group required  text-left">
                        <label class="control-label">Jenis Pembiayaan</label>
                        <input id="finance_type" class="form-control" readonly value="${data.finance_type}">
                    </div>
                    <div class="form-group required  text-left">
                        <label class="control-label">Sumber Dana</label>
                        <input id="fund" class="form-control" readonly value="${data.bank_name}">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required  text-left">
                                <label class="control-label">Jenis Margin</label>
                                <select id="interest_type" class="form-control" required value="${data.interest_type}">
                                    <option value="flat" ${data.interest_type=='flat' ? 'selected':''}>Flat</option>
                                    <option value="anuitas"  ${data.interest_type=='anuitas' ? 'selected':''}>Anuitas</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required text-left">
                                <label class="control-label">Margin</label>
                                <input type="number" step="0.01" id="interest" class="form-control" required value="${data.interest}">
                            </div>
                        </div>
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
            $.ajax({
                url: values.url,
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    contract_date:values.contract_date,
                    contract_number:values.contract_number,
                    interest:values.interest,
                    interest_type:values.interest_type,
                },
                xhrFields: {responseType: "blob"},
                success: function (data) {
                    var blob = new Blob([data], {type: "application/octet-stream"});
                    const downloadUrl = URL.createObjectURL(blob);
                    const a = document.createElement("a");
                    a.href = downloadUrl;
                    a.download = values.contract_number+".pdf";
                    document.body.appendChild(a);
                    a.click();
                }
            });
        }

        function getData(){
            var employeeDT = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                filter: true,
                fixedColumns: {
                    leftColumns: 4,
                    rightColumns: 1,
                },
                scrollCollapse: true,
                scrollX: true,
                ajax: {
                    url: "{!! route('monitoring.datatable') !!}",
                    type: 'GET'
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: 'date', name: 'date', searchable: false, orderable: false},
                    { data: 'nopen', name: 'nopen', searchable: false, orderable: false},
                    { data: 'name', name: 'name', searchable: false, orderable: false},
                    { data: 'bank_name', name: 'bank_name', searchable: false, orderable: false},
                    { data: 'product_name', name: 'product_name', searchable: false, orderable: false},
                    { data: 'finance_type', name: 'finance_type', searchable: false, orderable: false},
                    { data: 'tenor', name: 'tenor', searchable: false, orderable: false},
                    { data: 'plafon', name: 'plafon', searchable: false, orderable: false},
                    { data: 'view_installment', name: 'view_installment', searchable: false, orderable: false},
                    { data: 'print_akad', name: 'print_akad', searchable: false, orderable: false},
                    { data: 'view_akad', name: 'view_akad', searchable: false, orderable: false},
                    { data: 'slik_status', name: 'slik_status', searchable: false, orderable: false},
                    { data: 'slik_description', name: 'slik_description', searchable: false, orderable: false},
                    { data: 'slik_checker_name', name: 'slik_checker_name', searchable: false, orderable: false},
                    { data: 'slik_date', name: 'slik_date', searchable: false, orderable: false},
                    { data: 'verification_status', name: 'verification_status', searchable: false, orderable: false},
                    { data: 'verification_description', name: 'verification_description', searchable: false, orderable: false},
                    { data: 'verification_checker_name', name: 'verification_checker_name', searchable: false, orderable: false},
                    { data: 'verification_date', name: 'verification_date', searchable: false, orderable: false},
                    { data: 'approval_status', name: 'approval_status', searchable: false, orderable: false},
                    { data: 'approval_description', name: 'approval_description', searchable: false, orderable: false},
                    { data: 'approval_checker_name', name: 'approval_checker_name', searchable: false, orderable: false},
                    { data: 'approval_date', name: 'approval_date', searchable: false, orderable: false},
                    { data: 'disbursement_status', name: 'disbursement_status', searchable: false, orderable: false},
                    { data: 'disbursement_date', name: 'disbursement_date', searchable: false, orderable: false},
                    { data: 'action', name: 'action',searchable: false, orderable: false},
                ]
            });
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
            $('#dataTable').DataTable().ajax.url("{!! route('monitoring.datatable') !!}?"+params.toString()).load();
        }

        $('#modalViewFile').on('show.bs.modal', function (event) {
            var data = $(event.relatedTarget).data()
            var modal = $(this)
            modal.find('.modal-title').text(data.title)
            var modalContent = `<iframe
                            src="${data.url}"
                            frameBorder="0"
                            scrolling="auto"
                            height="600px"
                            width="100%"
                        ></iframe>`
            if(data.type){
                if(data.type=='video'){
                    modalContent = `<video src="${data.url}" height="auto" width="100%" controls></video>`
                }else if(data.type=='img'){
                    modalContent = `<img src="${data.url}" class="img img-responsive" />`
                }

            }
            modal.find('.modal-body').html(modalContent)
        })
    </script>
@endpush
