@extends('layouts.template')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pengaturan Pengguna</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Pengaturan Pengguna</a></li>
                    <li class="breadcrumb-item active">Pengguna</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection
@section('title','Users')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Pengguna</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table id="userTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
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
        var createAccess={!!check_access('user','create')!!}
        $(function () {
            var roleDT = $('#userTable').DataTable({
                processing: true,
                serverSide: true,
                filter: true,
                buttons: ["copy"],
                ajax: {
                    url: "{!! route('user.datatable') !!}",
                    type: 'GET'
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: 'name', name: 'name'},
                    { data: 'email', name: 'email'},
                    { data: 'role', name: 'role'},
                    { data: 'action', name: 'action', class: 'text-center', searchable: false, orderable: false },
                ]
            });
            if(createAccess==1){
                $('#userTable_length').append(`<div class="dt-buttons btn-group flex-wrap" style="margin-left:10px;"><a  href="{!!route('user.create')!!}" class="btn btn-success btn-sm btn-md"><i class="nav-icon fas fa-plus"></i> Tambah</a></div>`)
            }
        })
    </script>
@endpush
