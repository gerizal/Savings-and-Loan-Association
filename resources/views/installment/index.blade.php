@extends('layouts.template')
@section('title','Upload Dokumen')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Jadwal Angsuran</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Angsuran</li>
                    <li class="breadcrumb-item active">Jadwal</li>
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
                            <th rowspan="2">Nama Pemohon</th>
                            <th rowspan="2">Nopen</th>
                            <th rowspan="2">Produk</th>
                            <th rowspan="2">Jeni Pembiayaan</th>
                            <th rowspan="2">Plafond</th>
                            <th rowspan="2">Tenor</th>
                            <th rowspan="2">Sisa Tenor</th>
                            <th rowspan="2">Angsuran Ke</th>
                            <th rowspan="2">Jadwal Bayar</th>
                            <th colspan="3" class="text-center">Angsuran</th>
                            <th rowspan="2" class="text-center">Sisa Plafond</th>
                            <th rowspan="2" class="text-center">Status Pembayaran</th>
                            <th rowspan="2" class="text-center">Tanggal Pembayaran</th>
                            <th rowspan="2" class="text-center">Aksi</th>
                        </tr>
                        <tr>
                            <th class="text-center">Angsuran Perbulan</th>
                            <th class="text-center">Angsuran Bank</th>
                            <th class="text-center">Angsuran Koperasi</th>
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
                        <option value="">Semua</option>
                        <option value="1">Bayar</option>
                        <option value="0">Belum Bayar</option>
                    </select>
                </label>
                <label>
                    <select class="custom-select custom-select-sm form-control form-control-sm" id="group" placeholder="Group" aria-controls="dataTable">
                        <option value="">Semua</option>
                        <option value="flash">Flash</option>
                        <option value="non_flash">Non Flash</option>
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

        function getData(){
            var employeeDT = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                filter: true,
                fixedColumns: {
                    leftColumns: 4
                },
                scrollCollapse: true,
                scrollX: true,
                createdRow: function (row, data, dataIndex) {
                    // if (data.status == '0') {
                        // $(row).addClass('bg-yellow');
                    // }
                },
                ajax: {
                    url: "{!! route('installment.data-table-installment') !!}",
                    type: 'GET'
                },
                columns: [
                    { data: 'applicant_name', name: 'applicant_name', searchable: false, orderable: false},
                    { data: 'nopen', name: 'nopen', searchable: false, orderable: false},
                    { data: 'product_name', name: 'product_name', searchable: false, orderable: false},
                    { data: 'finance_name', name: 'finance_name', searchable: false, orderable: false},
                    { data: 'plafon', name: 'plafon', searchable: false, orderable: false},
                    { data: 'tenor', name: 'tenor', searchable: false, orderable: false},
                    { data: 'tenor_left', name: 'tenor_left', searchable: false, orderable: false},
                    { data: 'number', name: 'number', searchable: false, orderable: false},
                    { data: 'payment_date', name: 'payment_date', searchable: false, orderable: false},
                    { data: 'amount', name: 'amount', searchable: false, orderable: false},
                    { data: 'margin_bank', name: 'margin_bank', searchable: false, orderable: false},
                    { data: 'colfee', name: 'colfee', searchable: false, orderable: false},
                    { data: 'remains', name: 'remains', searchable: false, orderable: false},
                    { data: 'status_label', name: 'status_label', searchable: false, orderable: false},
                    { data: 'settlement_date', name: 'settlement_date', searchable: false, orderable: false},
                    { data: 'action', name: 'action', searchable: false, orderable: false},
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
            $('#dataTable').DataTable().ajax.url("{!! route('installment.data-table-installment') !!}?"+params.toString()).load();
        }

        $(document).on('click', '.btn-payment', function(event) {
            let data = $(this).data();
            console.log('DATA', data);
            Swal.fire({
                title: "Bayar Tagihan",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "<i class='fa fa-check'></i>&nbsp;Bayar",
                cancelButtonText: "<i class='fa fa-times'></i>&nbsp;Batal",
                reverseButtons: true,
                didOpen: function() {
                    $('#datetimepicker').datetimepicker({
                        format: 'DD-MM-YYYY',
                    })
                },
                preConfirm: () => {
                    let result ={
                        status: data.status,
                        file:$('#file')[0].files[0],
                        payment_type: document.getElementById("payment_type").value,
                        description: document.getElementById("description").value,
                    }
                    return result
                },
                html:`
                    <div class="form-group text-left">
                        <label class="control-label">No Akad</label>
                        <input id="contract_number" class="form-control" readonly value="${data.akad}">
                    </div>
                    <div class="form-group text-left">
                        <label class="control-label">Angsuran Ke</label>
                        <input id="number" class="form-control" readonly value="${data.number}">
                    </div>
                    <div class="form-group text-left">
                        <label class="control-label">Metode Pembayaran</label>
                        <select id="payment_type" name="payment_type" class="form-control">
                            <option value="cash" selected>Tunai</option>
                            <option value="transfer">Transfer</option>
                        </select>
                    </div>
                    <div class="form-group text-left">
                        <label class="control-label">Bukti Bayar</label>
                        <input id="file" type="file" class="form-control">
                    </div>
                    <div class="form-group text-left">
                        <label class="control-label">Keterangan</label>
                        <textarea id="description" class="form-control"></textarea>
                    </div>
                `
            }).then((result) => {
                if (result.isConfirmed) {
                    pay(data.url, result.value)
                }
            });
        });

        function pay(url, values){
            var status = values.status == 0 ? 1:0
            var formData = new FormData();
            formData.append("status", status);
            formData.append("file", values.file);
            formData.append("payment_type", values.payment_type);
            formData.append("description", values.description);
            $.ajax({
                url: url,
                type: "post",
                headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    reloadDataTable()
                }
            });
        }
    </script>
@endpush
