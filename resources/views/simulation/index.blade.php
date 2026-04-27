@extends('layouts.template')
@section('title','Simulasi')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Simulasi Pinjaman</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Simulasi Pinjaman</li>
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
                <h3 class="card-title">Data Simulasi</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tanggal Lahir</th>
                            <th>Gaji</th>
                            <th>Plafon</th>
                            <th>Tenor</th>
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

        var createAccess={!!check_access('simulasi_pinjaman','create')!!}
        $(function () {
            var employeeDT = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                filter: true,
                ajax: {
                    url: "{!! route('simulation.datatable') !!}",
                    type: 'GET'
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: 'name', name: 'name'},
                    { data: 'birth_date', name: 'birth_date'},
                    { data: 'salary', name: 'salary'},
                    { data: 'plafon', name: 'plafon'},
                    { data: 'tenor', name: 'tenor'},
                    { data: 'action', name: 'action',searchable: false, orderable: false},
                ]
            });
            if(createAccess==1){
                $('#dataTable_length').append(`<div class="dt-buttons btn-group flex-wrap" style="margin-left:10px;"><a  href="{!!route('simulation.create')!!}" class="btn btn-success btn-sm btn-md"><i class="nav-icon fas fa-plus"></i> Tambah</a></div>`)
            }
        })
    </script>
@endpush
