@extends('layouts.template')
@section('title','Tambah Karyawan')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Karyawan</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('master-data.employee.index')}}">Master Data</a></li>
                    <li class="breadcrumb-item"><a href="{{route('master-data.employee.index')}}">Karyawan</a></li>
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
    <div class="col-sm-12 col-md-12">
      <!-- jquery validation -->
        <div class="card">
            <!-- /.card-header -->
            <!-- form start -->
            {!! Form::model($data, $form) !!}
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required @error('first_name') has-danger @enderror">
                                        {!! Form::label('Nama Depan', null, ['class' => 'control-label']) !!}
                                        {!! Form::text('first_name', null, ['class' => "form-control".($errors->has('first_name') ? ' is-invalid' : ''), 'id'=>'first_name','placeholder'=>'Nama Depan']) !!}
                                        @if($errors->has('first_name'))
                                            <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        {!! Form::label('Nama Belakang', null, ['class' => 'control-label']) !!}
                                        {!! Form::text('last_name', null, ['class' => "form-control".($errors->has('last_name') ? ' is-invalid' : ''), 'id'=>'last_name','placeholder'=>'Nama Belakang']) !!}
                                        @if($errors->has('last_name'))
                                            <span class="error invalid-feedback">{{ $errors->first('last_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        {!! Form::label('Email', null, ['class' => 'control-label']) !!}
                                        {!! Form::email('email', null, ['class' => "form-control".($errors->has('email') ? ' is-invalid' : ''), 'id'=>'email','placeholder'=>'Email']) !!}
                                        @if($errors->has('email'))
                                            <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="form-group required">
                                        {!! Form::label('NIP', null, ['class' => 'control-label']) !!}
                                        {!! Form::text('employee_id', null, ['class' => "form-control".($errors->has('employee_id') ? ' is-invalid' : ''), 'id'=>'employee_id','placeholder'=>'NIP']) !!}
                                        @if($errors->has('employee_id'))
                                            <span class="error invalid-feedback">{{ $errors->first('employee_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group required">
                                        {!! Form::label('NIK', null, ['class' => 'control-label']) !!}
                                        {!! Form::text('id_number', null, ['class' => "form-control".($errors->has('id_number') ? ' is-invalid' : ''), 'id'=>'id_number','placeholder'=>'NIK']) !!}
                                        @if($errors->has('id_number'))
                                            <span class="error invalid-feedback">{{ $errors->first('id_number') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required @error('birth_place') has-danger @enderror">
                                        {!! Form::label('Tempat Lahir', null, ['class' => 'control-label']) !!}
                                        {!! Form::text('birth_place', null, ['class' => "form-control".($errors->has('birth_place') ? ' is-invalid' : ''), 'id'=>'birth_place','placeholder'=>'Tempat Lahir']) !!}
                                        @if($errors->has('birth_place'))
                                            <span class="error invalid-feedback">{{ $errors->first('birth_place') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        {!! Form::label('Tanggal Lahir', null, ['class' => 'control-label']) !!}
                                        <div class="input-group date" id="birth_date" data-target-input="nearest">
                                            {!! Form::text('birth_date', '', ['class' => 'date-mask form-control datetimepicker-input'.($errors->has('birth_date') ? ' is-invalid' : ''),'placeholder'=>'Tanggal Lahir','data-target'=>'#birth_date']) !!}
                                            <div class="input-group-append" data-target="#birth_date" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        @if($errors->has('birth_date'))
                                            <span class="error invalid-feedback">{{ $errors->first('birth_date') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        {!! Form::label('No Telepon', null, ['class' => 'control-label']) !!}
                                        <div class="input-group">
                                            {!! Form::text('phone_number', null, ['class' => "form-control".($errors->has('phone_number') ? ' is-invalid' : ''), 'id'=>'phone_number','placeholder'=>'No Telepon']) !!}
                                            <div class="input-group-append">
                                                <div class="input-group-text"><i class="fa fa-phone"></i></div>
                                            </div>
                                        </div>
                                        @if($errors->has('phone_number'))
                                            <span class="error invalid-feedback">{{ $errors->first('phone_number') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group required">
                                        {!! Form::label('Alamat', null, ['class' => 'control-label']) !!}
                                        {!! Form::textarea('address', null, ['class' => "form-control".($errors->has('address') ? ' is-invalid' : ''), 'id'=>'address','placeholder'=>'Alamat','rows'=>'4']) !!}
                                        @if($errors->has('address'))
                                            <span class="error invalid-feedback">{{ $errors->first('address') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group required">
                                                {!! Form::label('Nama User', null, ['class' => 'control-label']) !!}
                                                {!! Form::text('name', null, ['class' => "form-control".($errors->has('name') ? ' is-invalid' : ''), 'id'=>'username','placeholder'=>'Nama User']) !!}
                                                @if($errors->has('name'))
                                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group required">
                                                {!! Form::label('Role User', null, ['class' => 'control-label']) !!}
                                                {!! Form::select('role_id', $roles,null, ['class' => "form-control".($errors->has('role_id') ? ' is-invalid' : ''), 'id'=>'role','placeholder'=>'Pilih Role']) !!}
                                                @if($errors->has('role_id'))
                                                    <span class="error invalid-feedback">{{ $errors->first('role_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group required">
                                                {!! Form::label('Password', null, ['class' => 'control-label']) !!}
                                                <div class="input-group mb-3">
                                                    {!! Form::text('password', null, ['class' => "form-control".($errors->has('password') ? ' is-invalid' : ''), 'id'=>'password','placeholder'=>'Password']) !!}
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fas fa-eye nav-icon"></i></span>
                                                    </div>
                                                </div>
                                                @if($errors->has('password'))
                                                    <span class="error invalid-feedback">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group required">
                                                {!! Form::label('Unit Cabang', null, ['class' => 'control-label']) !!}
                                                {!! Form::select('branch_unit_id', $branch_unit, null, ['class' => "form-control".($errors->has('branch_unit_id') ? ' is-invalid' : ''), 'id'=>'branch_unit_id','placeholder'=>'Pilih Cabang']) !!}
                                                @if($errors->has('branch_unit_id'))
                                                    <span class="error invalid-feedback">{{ $errors->first('branch_unit_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="img-preview text-center">
                                                @if($data->avatar==null || $data->avatar=='')
                                                    <img src="{{asset('img/no-avatar.jpg')}}" class="img-user-preview img-responsive" id="img-user">

                                                @else
                                                    <img src="{{generateSecureUrl($data->avatar)}}" class="img-user-preview img-responsive"  id="img-user">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                        <input type="file" name="picture" accept="image/*" onchange="loadFile(event)" class="form-control {{$errors->has('picture') ? ' is-invalid' : ''}}">
                                        @if($errors->has('picture'))
                                            <span class="error invalid-feedback">{{ $errors->first('picture') }}</span>
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- <div class="col-md-12"> -->
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Jabatan', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('job_title', null, ['class' => "form-control".($errors->has('job_title') ? ' is-invalid' : ''), 'id'=>'job_title','placeholder'=>'Jabatan']) !!}
                                            @if($errors->has('job_title'))
                                                    <span class="error invalid-feedback">{{ $errors->first('job_title') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Status PKWT', null, ['class' => 'control-label']) !!}
                                            {!! Form::select('status_pkwt',array('Baru' => 'Baru', 'Aktif' => 'Aktif'),null, ['class' => "form-control".($errors->has('Pilih Status PKWT') ? ' is-invalid' : ''), 'id'=>'role','placeholder'=>'Pilih Status PKWT']) !!}
                                            @if($errors->has('status_pkwt'))
                                                <span class="error invalid-feedback">{{ $errors->first('status_pkwt') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Masa Kontrak (Tahun)', null, ['class' => 'control-label']) !!}
                                            {!! Form::number('masa_kontrak', null, ['class' => "form-control".($errors->has('masa_kontrak') ? ' is-invalid' : ''), 'id'=>'masa_kontrak','placeholder'=>'Masa Kontrak']) !!}
                                            @if($errors->has('masa_kontrak'))
                                                <span class="error invalid-feedback">{{ $errors->first('masa_kontrak') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Target (Tahun)', null, ['class' => 'control-label']) !!}
                                            {!! Form::number('target', null, ['class' => "form-control".($errors->has('target') ? ' is-invalid' : ''), 'id'=>'target','placeholder'=>'Target']) !!}
                                            @if($errors->has('target'))
                                                <span class="error invalid-feedback">{{ $errors->first('target') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-right">
                    <a href="{{route('master-data.employee.index')}}" class="btn btn-default"><i class="fas fa-times"></i> Batal</a>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
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

@push('script')
<script>
    $(function () {
        $('#birth_date').datetimepicker({
            format: 'DD-MM-YYYY'
        })

        var date_of_birth = "{{$data->birth_date == ''? '' : $data->birth_date}}"
        if(date_of_birth != ''){
            $('#birth_date').datetimepicker('date', date_of_birth);
        }
    })


    var loadFile = function(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('img-user');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    };

</script>
@endpush
