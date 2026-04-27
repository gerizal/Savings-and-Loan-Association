@extends('layouts.template')
@section('title','Data Pembiayaan')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Master Data Pembiayaan</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Master Data</li>
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
            <div class="card-header">
                <h3 class="card-title">Data Sumber Dana</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table id="sourceFund" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Admin Koperasi (%)</th>
                            <th>Admin Bank (%)</th>
                            <th>Tata Lakasana (Rp)</th>
                            <th>Materai (Rp)</th>
                            <th>Buka Rekening (Rp)</th>
                            <th>Flaging (Rp)</th>
                            <th>Epotpen (Rp)</th>
                            <th>Provisi (Rp)</th>
                            <th>Sisa Gaji (%)</th>
                            <th>Bunga Bank (%)</th>
                            <th>Syariah</th>
                            <th>Aksi</th>
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

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Jenis Pembiayaan</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body  table-responsive">
                <table id="typeFinance" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Biaya Mutasi</th>
                            <th>Aksi</th>
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

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Produk Pembiayaan</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body  table-responsive">
                <table id="financeProduct" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Asuransi (%)</th>
                            <th>Bunga (%)</th>
                            <th>Min Usia</th>
                            <th>Max Usia</th>
                            <th>Max Usia Lunas</th>
                            <th>Max Tenor</th>
                            <th>Max Plafon</th>
                            <th>Bank</th>
                            <th>Aksi</th>
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
        var createBank={!!check_access('master_data_pembiayaan','create')!!}
        var createType={!!check_access('master_data_pembiayaan','create')!!}
        var createProduct={!!check_access('master_data_pembiayaan','create')!!}
        $(function () {
            var sourceFundDT = $('#sourceFund').DataTable({
                processing: true,
                serverSide: true,
                filter: true,
                fixedColumns: {
                    leftColumns: 2,
                    rightColumns: 1,
                },
                scrollCollapse: true,
                scrollX: true,
                buttons: ["copy"],
                ajax: {
                    url: "{!! route('master-data.datatable.bank') !!}",
                    type: 'GET'
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: 'name', name: 'name'},
                    { data: 'coop_fee', name: 'coop_fee'},
                    { data: 'administration_fee', name: 'administration_fee'},
                    { data: 'management_fee', name: 'management_fee'},
                    { data: 'stamp_fee', name: 'stamp_fee'},
                    { data: 'account_opening_fee', name: 'account_opening_fee'},
                    { data: 'flagging_fee', name: 'flagging_fee'},
                    { data: 'epotpen_fee', name: 'epotpen_fee'},
                    { data: 'provision_fee', name: 'provision_fee'},
                    { data: 'installment_fee', name: 'installment_fee'},
                    { data: 'interest', name: 'interest'},
                    { data: 'is_syariah', name: 'is_syariah'},
                    { data: 'action', name: 'action', searchable: false, orderable: false},
                ]
            });

            if(createBank==1){
                $('#sourceFund_length').append(`<div class="dt-buttons btn-group flex-wrap" style="margin-left:10px;"><a  href="{!!route('master-data.bank.create')!!}" class="btn btn-success btn-sm btn-md"><i class="nav-icon fas fa-plus"></i> Tambah</a></div>`)
            }

            var typeFinanceDT = $('#typeFinance').DataTable({
                processing: true,
                serverSide: true,
                filter: true,
                buttons: ["copy"],
                ajax: {
                    url: "{!! route('master-data.datatable.finance') !!}",
                    type: 'GET'
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: 'name', name: 'name'},
                    { data: 'mutation_fee', name: 'mutation_fee'},
                    { data: 'action', name: 'action',searchable: false, orderable: false},
                ]
            });

            if(createType==1){
                $('#typeFinance_length').append(`<div class="dt-buttons btn-group flex-wrap" style="margin-left:10px;"><a  href="{!!route('master-data.finance.create')!!}" class="btn btn-success btn-sm btn-md"><i class="nav-icon fas fa-plus"></i> Tambah</a></div>`)
            }

            var financeProductDT = $('#financeProduct').DataTable({
                processing: true,
                serverSide: true,
                filter: true,
                buttons: ["copy"],
                ajax: {
                    url: "{!! route('master-data.datatable.product') !!}",
                    type: 'GET'
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: 'name', name: 'name'},
                    { data: 'insurance_fee', name: 'insurance_fee'},
                    { data: 'interest', name: 'interest'},
                    { data: 'min_age', name: 'min_age'},
                    { data: 'max_age', name: 'max_age'},
                    { data: 'max_paid_age', name: 'max_paid_age'},
                    { data: 'max_tenor', name: 'max_tenor'},
                    { data: 'max_plafon', name: 'max_plafon'},
                    { data: 'bank_name', name: 'bank_name'},
                    { data: 'action', name: 'action'},
                ]
            });
            if(createProduct==1){
                $('#financeProduct_length').append(`<div class="dt-buttons btn-group flex-wrap" style="margin-left:10px;"><a  href="{!!route('master-data.product.create')!!}" class="btn btn-success btn-sm btn-md"><i class="nav-icon fas fa-plus"></i> Tambah</a></div>`)
            }
        })
    </script>
@endpush
