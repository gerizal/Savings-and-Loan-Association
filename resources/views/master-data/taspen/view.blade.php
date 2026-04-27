@extends('layouts.template')
@section('title','Tambah Taspen')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Taspen</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('master-data.taspen.index')}}">Master Data</a></li>
                    <li class="breadcrumb-item"><a href="{{route('master-data.taspen.index')}}">Taspen</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
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
    <!-- left column -->
    <div class="col-sm-4 col-md-4 offset-md-4 offset-sm-4">
      <!-- jquery validation -->
        <div class="card">
            {{-- <div class="card-header">
                <h3 class="card-title">Quick Example <small>jQuery Validation</small></h3>
            </div> --}}
            <!-- /.card-header -->
            <!-- form start -->
            {!! Form::model($data, []) !!}
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('Nama Depan', null, ['class' => 'control-label']) !!}
                                        {!! Form::text('first_name', null, ['class' => 'form-control', 'disabled' => true, 'id'=>'first_name','placeholder'=>'Nama Depan']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('Nama Belakang', null, ['class' => 'control-label']) !!}
                                        {!! Form::text('last_name', null, ['class' => 'form-control', 'disabled' => true, 'id'=>'last_name','placeholder'=>'Nama Belakang']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('Email', null, ['class' => 'control-label']) !!}
                                        {!! Form::email('email', null, ['class' => 'form-control', 'disabled' => true, 'id'=>'email','placeholder'=>'Email']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('NIP', null, ['class' => 'control-label']) !!}
                                        {!! Form::text('employee_id', null, ['class' => 'form-control', 'disabled' => true, 'id'=>'employee_id','placeholder'=>'NIP']) !!}
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        {!! Form::label('NIK', null, ['class' => 'control-label']) !!}
                                        {!! Form::text('id_number', null, ['class' => 'form-control', 'disabled' => true, 'id'=>'id_number','placeholder'=>'NIK']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('Tempat Lahir', null, ['class' => 'control-label']) !!}
                                        {!! Form::text('birth_place', null, ['class' => 'form-control', 'disabled' => true, 'id'=>'id_number','placeholder'=>'Tempat Lahir']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('Tanggal Lahir', null, ['class' => 'control-label']) !!}
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            {!! Form::text('birth_date', null, ['class' => 'date-mask form-control datetimepicker-input', 'disabled' => true, 'id'=>'birth_date','placeholder'=>'Tanggal Lahir','data-target'=>'#reservationdate']) !!}
                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('No Telepon', null, ['class' => 'control-label']) !!}
                                        <div class="input-group">
                                            {!! Form::text('phone_number', null, ['class' => 'form-control', 'disabled' => true, 'id'=>'phone_number','placeholder'=>'No Telepon']) !!}
                                            <div class="input-group-append">
                                                <div class="input-group-text"><i class="fa fa-phone"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('Alamat', null, ['class' => 'control-label']) !!}
                                        {!! Form::textarea('address', null, ['class' => 'form-control', 'disabled' => true, 'id'=>'address','placeholder'=>'Alamat','rows'=>'4']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('Nama User', null, ['class' => 'control-label']) !!}
                                                {!! Form::text('username', null, ['class' => 'form-control', 'disabled' => true, 'id'=>'username','placeholder'=>'Nama User']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('Provinsi', null, ['class' => 'control-label']) !!}
                                                {!! Form::select('role', $provinces,null, ['class' => 'form-control','disabled' => true, 'id'=>'role','placeholder'=>'Role']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('Password', null, ['class' => 'control-label']) !!}
                                                <div class="input-group mb-3">
                                                    {!! Form::text('password', null, ['class' => 'form-control', 'disabled' => true, 'id'=>'password','placeholder'=>'Password']) !!}
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-eye nav-icon"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <!-- <div class="col-md-12"> -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('Jabatan', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('job_title', null, ['class' => 'form-control', 'disabled' => true, 'id'=>'job_title','placeholder'=>'Jabatan']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('Status PKWT', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('status_pkwt', null, ['class' => 'form-control', 'disabled' => true, 'id'=>'status_pkwt','placeholder'=>'Status PKWT']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('Masa Kontrak', null, ['class' => 'control-label']) !!}
                                            {!! Form::number('masa_kontrak', null, ['class' => 'form-control', 'disabled' => true, 'id'=>'contract_term','placeholder'=>'Masa Kontrak']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('Target', null, ['class' => 'control-label']) !!}
                                            {!! Form::number('target', null, ['class' => 'form-control', 'disabled' => true, 'id'=>'target','placeholder'=>'Target']) !!}
                                        </div>
                                    </div>
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-right">
                    <a href="{{route('master-data.taspen.index')}}" class="btn btn-default"><i class="fas fa-times"></i> Kembali</a>
                    <a href="{{route('master-data.taspen.edit', $data->id)}}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.card -->
    </div>
    <!--/.col (left) -->
    <!-- right column -->
    <div class="col-md-6">

    </div>
    <!--/.col (right) -->
</div>

@endsection
