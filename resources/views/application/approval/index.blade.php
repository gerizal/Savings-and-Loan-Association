@extends('layouts.template')
@section('title','Data Approval Bank')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Approval Bank</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pengajuan</li>
                    <li class="breadcrumb-item active">Approval Bank</li>
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
                <input type="hidden" id="start_date"/>
                <input type="hidden" id="end_date"/>
                <table id="dataTable" class="table table-bordered table-striped table-hover" width="100%">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Tanggal Pengajuan</th>
                            <th rowspan="2">No Pensiun</th>
                            <th rowspan="2">Nama Pemohon</th>
                            <th rowspan="2">Produk Pembiayaan</th>
                            <th rowspan="2">Jenis Pembiayaan</th>
                            <th rowspan="2">Tenor</th>
                            <th rowspan="2">Plafon</th>
                            <th colspan="4"  class="text-center bg-success">Informasi Slik</th>
                            <th colspan="4"  class="text-center bg-primary">Informasi Verifikasi</th>
                            <th colspan="4"  class="text-center bg-info">Informasi Approval</th>
                            <th rowspan="2">Aksi</th>
                        </tr>
                        <tr>
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
                    url: "{!! route('application.approval.datatable') !!}",
                    type: 'GET'
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: 'date', name: 'date', searchable: false, orderable: false},
                    { data: 'nopen', name: 'nopen', searchable: false, orderable: false},
                    { data: 'name', name: 'name', searchable: false, orderable: false},
                    { data: 'product_name', name: 'product_name', searchable: false, orderable: false},
                    { data: 'finance_type', name: 'finance_type', searchable: false, orderable: false},
                    { data: 'tenor', name: 'tenor', searchable: false, orderable: false},
                    { data: 'plafon', name: 'plafon', searchable: false, orderable: false},
                    { data: 'slik_status', name: 'slik_status', searchable: false, orderable: false},
                    { data: 'slik_description', name: 'slik_description', searchable: false, orderable: false},
                    { data: 'slik_checker_name', name: 'slik_checker_name', searchable: false, orderable: false},
                    { data: 'slik_updated_at', name: 'slik_updated_at', searchable: false, orderable: false},
                    { data: 'verification_status', name: 'verification_status', searchable: false, orderable: false},
                    { data: 'verification_description', name: 'verification_description', searchable: false, orderable: false},
                    { data: 'verification_checker_name', name: 'verification_checker_name', searchable: false, orderable: false},
                    { data: 'verification_updated_at', name: 'verification_updated_at', searchable: false, orderable: false},
                    { data: 'status', name: 'status', searchable: false, orderable: false},
                    { data: 'description', name: 'description', searchable: false, orderable: false},
                    { data: 'checker_name', name: 'checker_name', searchable: false, orderable: false},
                    { data: 'updated_at', name: 'updated_at', searchable: false, orderable: false},
                    { data: 'action', name: 'action',searchable: false, orderable: false},
                ]
            });

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
                        <option value="pending">Pending</option>
                        <option value="on process">Diproses</option>
                        <option value="approve">Disetujui</option>
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
        })

        function reloadDataTable(){
            var startDate = $('#start_date').val() || ''
            var endDate = $('#end_date').val() || ''
            var status = $('#status').val() || ''
            var bank = $('#bank').val() || ''
            var params = new URLSearchParams({
                'start_date': startDate,
                'end_date': endDate,
                'status': status,
                'bank': bank
            });
            $('#dataTable').DataTable().ajax.url("{!! route('application.approval.datatable') !!}?"+params.toString()).load();
        }
    </script>
@endpush
