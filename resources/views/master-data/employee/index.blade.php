@extends('layouts.template')
@section('title','Data Karyawan')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Master Data Karyawan</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Master Data</li>
                    <li class="breadcrumb-item active">Karyawan</li>
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
                <table id="employeeTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>No Induk Pegawai</th>
                            <th>Email</th>
                            <th>Jabatan</th>
                            <th>Tanggal Lahir</th>
                            <th>Status</th>
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
        var createAccess={!!check_access('master_data_karyawan','create')!!}
        $(function () {
            var employeeDT = $('#employeeTable').DataTable({
                processing: true,
                serverSide: true,
                filter: true,
                buttons: ["copy"],
                ajax: {
                    url: "{!! route('master-data.datatable.employee') !!}",
                    type: 'GET'
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: 'fullname', name: 'fullname',searchable: false},
                    { data: 'employee_id', name: 'employee_id',searchable: false},
                    { data: 'email', name: 'email',searchable: false},
                    { data: 'job_title', name: 'job_title',searchable: false},
                    { data: 'birth_date', name: 'birth_date',searchable: false},
                    { data: 'status_pkwt', name: 'status_pkwt',searchable: false},
                    { data: 'action', name: 'action',searchable: false, orderable: false},
                ]
            });
            if(createAccess==1){
                $('#employeeTable_length').append(`<div class="dt-buttons btn-group flex-wrap" style="margin-left:10px;"><a  href="{!!route('master-data.employee.create')!!}" class="btn btn-success btn-sm btn-md"><i class="nav-icon fas fa-plus"></i> Tambah</a></div>`)
            }
        })
    </script>
@endpush
