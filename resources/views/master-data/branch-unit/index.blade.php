@extends('layouts.template')
@section('title','Data Unit Cabang')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Master Data Unit Cabang</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Master Data</li>
                    <li class="breadcrumb-item active">Unit Cabang</li>
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
                <h3 class="card-title">Data Jenis Pembiayaan</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <!-- <th>Kode Area</th> -->
                            <th>Number Kode</th>
                            <!-- <th>Alamat</th> -->
                            <th>Unit Pelayanan</th>
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
        var createAccess={!!check_access('master_data_cabang','create')!!}
        $(function () {
            var employeeDT = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                filter: true,
                buttons: ["copy"],
                ajax: {
                    url: "{!! route('master-data.datatable.branch-unit') !!}",
                    type: 'GET'
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: 'name', name: 'name'},
                    // { data: 'code_area', name: 'code_area'},
                    { data: 'number_code', name: 'number_code'},
                    // { data: 'address', name: 'address'},
                    { data: 'unit_pelayanan', name: 'unit_pelayanan'},
                    { data: 'action', name: 'action',searchable: false, orderable: false},
                ]
            });
            if(createAccess==1){
                $('#dataTable_length').append(`<div class="dt-buttons btn-group flex-wrap" style="margin-left:10px;"><a  href="{!!route('master-data.branch-unit.create')!!}" class="btn btn-success btn-sm btn-md"><i class="nav-icon fas fa-plus"></i> Tambah</a></div>`)
            }
        })
    </script>
@endpush
