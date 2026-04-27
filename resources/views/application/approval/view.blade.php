@extends('layouts.template')
@section('title','Approval Bank')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detail Approval Bank</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('application.approval.index')}}">Approval Bank</a></li>
                    <li class="breadcrumb-item active">Detail</li>
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
    <div class="col-sm-6 col-md-6">
      <!-- jquery validation -->
        <div class="card">
            <!-- /.card-header -->
            <!-- form start -->
            {!! Form::model($data, $form) !!}
                <div class="card-body">
                    <div class="row">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link  active" id="btn-profile" data-toggle="tab" data-target="#profileTab" type="button" role="tab" aria-controls="profileTab" aria-selected="false">Data Diri</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="btn-guarantee" data-toggle="tab" data-target="#guaranteeTab" type="button" role="tab" aria-controls="guaranteeTab" aria-selected="false">Data Pensiun</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="btn-product" data-toggle="tab" data-target="#productTab" type="button" role="tab" aria-controls="productTab" aria-selected="false">Produk Pembiayaan dan Pinjaman</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="btn-service" data-toggle="tab" data-target="#serviceUnit" type="button" role="tab" aria-controls="serviceUnit" aria-selected="false">Unit Layanan dan Berkas</button>
                            </li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="tab-content  col-md-12" id="myTabContent">
                            <div class="tab-pane fade show active" id="profileTab" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="divider-line"><span>Personal Data</span></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Nopen', null, ['class' => 'control-label']) !!}
                                            {!! Form::select('taspen_id',$taspens, null, ['class' => "form-control".($errors->has('taspen_id') ? ' is-invalid' : ''), 'id'=>'taspen_id','placeholder'=>'Nopen']) !!}
                                            @if($errors->has('taspen_id'))
                                                <span class="error invalid-feedback">{{ $errors->first('taspen_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        <div class="form-group required @error('first_name') has-danger @enderror">
                                            {!! Form::label('Nama Lengkap', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('name', null, ['class' => "form-control".($errors->has('name') ? ' is-invalid' : ''), 'id'=>'name','placeholder'=>'Nama Lengkap','readonly'=>true]) !!}
                                            @if($errors->has('name'))
                                                <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('NIK', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('id_number', null, ['class' => "form-control".($errors->has('id_number') ? ' is-invalid' : ''), 'id'=>'id_number','placeholder'=>'NIK','readonly'=>true]) !!}
                                            @if($errors->has('id_number'))
                                                <span class="error invalid-feedback">{{ $errors->first('id_number') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Tempat Lahir', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('birth_place', null, ['class' => "form-control".($errors->has('birth_place') ? ' is-invalid' : ''), 'id'=>'birth_place','placeholder'=>'Tempat Lahir','readonly'=>true]) !!}
                                            @if($errors->has('birth_place'))
                                                <span class="error invalid-feedback">{{ $errors->first('birth_place') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Tanggal Lahir', null, ['class' => 'control-label']) !!}
                                            <div class="input-group date" id="birth_date" data-target-input="nearest">
                                                {!! Form::text('birth_date', null, ['class' => 'birth_date date-mask form-control datetimepicker-input'.($errors->has('birth_date') ? ' is-invalid' : ''),'placeholder'=>'Tanggal Lahir','data-target'=>'#birth_date','readonly'=>true]) !!}
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
                                            {!! Form::label('NPWP', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('tax_number', null, ['class' => "form-control".($errors->has('tax_number') ? ' is-invalid' : ''), 'id'=>'tax_number','placeholder'=>'Nomor NPWP','readonly'=>true]) !!}
                                            @if($errors->has('tax_number'))
                                                <span class="error invalid-feedback">{{ $errors->first('tax_number') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('No Telepon/HP', null, ['class' => 'control-label']) !!}
                                            <div class="input-group">
                                                {!! Form::text('phone_number', null, ['class' => "form-control".($errors->has('phone_number') ? ' is-invalid' : ''), 'id'=>'phone_number','placeholder'=>'No Telepon/HP','readonly'=>true]) !!}
                                                <div class="input-group-append">
                                                    <div class="input-group-text"><i class="fa fa-phone"></i></div>
                                                </div>
                                            </div>
                                            @if($errors->has('religion'))
                                                <span class="error invalid-feedback">{{ $errors->first('religion') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Jenis Kelamin', null, ['class' => 'control-label']) !!}
                                            {!! Form::select('gender',['Laki - laki'=>'Laki - laki','Perempuan'=>'Perempuan'], null, ['class' => "form-control".($errors->has('gender') ? ' is-invalid' : ''), 'id'=>'gender','placeholder'=>'Laki - laki/Perempuan','readonly'=>true]) !!}
                                            @if($errors->has('gender'))
                                                <span class="error invalid-feedback">{{ $errors->first('gender') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Pendidikan', null, ['class' => 'control-label']) !!}
                                            {!! Form::select('education',['SD'=>'SD','SMP'=>'SMP','SMA'=>'SMA','S1'=>'S1','S2'=>'S2','S3'=>'S3','DI'=>'DI','DII'=>'DII','DIII'=>'DIII','DIV'=>'DIV','Lainnya'=>'Lainnya'], null, ['class' => "form-control".($errors->has('education') ? ' is-invalid' : ''), 'id'=>'education','placeholder'=>'Pendidikan','readonly'=>true]) !!}
                                            @if($errors->has('education'))
                                                <span class="error invalid-feedback">{{ $errors->first('education') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Agama', null, ['class' => 'control-label']) !!}
                                            {!! Form::select('religion',['Islam'=>'Islam','Kristen Katholik'=>'Kristen Katholik','Kristen Protestan'=>'Kristen Protestan','Konghucu'=>'Konghucu','Hindu'=>'Hindu','Budha'=>'Budha'], null, ['class' => "form-control".($errors->has('religion') ? ' is-invalid' : ''), 'id'=>'religion','placeholder'=>'Agama','readonly'=>true]) !!}
                                            @if($errors->has('religion'))
                                                <span class="error invalid-feedback">{{ $errors->first('religion') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Nama Ibu Kandung', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('mother_name', null, ['class' => "form-control".($errors->has('mother_name') ? ' is-invalid' : ''), 'id'=>'mother_name','placeholder'=>'Nama Ibu Kandung','readonly'=>true]) !!}
                                            @if($errors->has('mother_name'))
                                                <span class="error invalid-feedback">{{ $errors->first('mother_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12"><div class="divider-line"><span>Alamat Sesuai KTP</span></div></div>
                                    <div class="col-md-12">
                                        <div class="form-group required">
                                            {!! Form::label('Alamat', null, ['class' => 'control-label']) !!}
                                            {!! Form::textarea('address', null, ['class' => "form-control map-input".($errors->has('address') ? ' is-invalid' : ''), 'id'=>'address','placeholder'=>'Alamat','rows'=>'3','readonly'=>true]) !!}
                                            @if($errors->has('address'))
                                                <span class="error invalid-feedback">{{ $errors->first('address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        {!! Form::hidden('address_latitude', null, ['class' => "form-control", 'id'=>'address_latitude']) !!}
                                        {!! Form::hidden('address_longitude', null, ['class' => "form-control", 'id'=>'address_longitude']) !!}
                                        <div id="address-map-container" style="width:100%;height:400px; ">
                                            <div style="width: 100%; height: 100%" id="address_map" class="map"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Provinsi', null, ['class' => 'control-label']) !!}
                                            {!! Form::select('province_id',$provinces, null, ['class' => "form-control".($errors->has('province_id') ? ' is-invalid' : ''), 'id'=>'province_id','placeholder'=>'Nama Provinsi','readonly'=>true]) !!}
                                            @if($errors->has('province_id'))
                                                <span class="error invalid-feedback">{{ $errors->first('province_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Kota/Kabupaten', null, ['class' => 'control-label']) !!}
                                            {!! Form::select('city_id',$cities, null, ['class' => "form-control".($errors->has('city_id') ? ' is-invalid' : ''), 'id'=>'city_id','placeholder'=>'Nama Kota/Kabupaten','readonly'=>true]) !!}
                                            @if($errors->has('city_id'))
                                                <span class="error invalid-feedback">{{ $errors->first('city_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Kecamatan', null, ['class' => 'control-label']) !!}
                                            {!! Form::select('district_id',$districts, null, ['class' => "form-control".($errors->has('district_id') ? ' is-invalid' : ''), 'id'=>'district_id','placeholder'=>'Nama Kecamatan','readonly'=>true]) !!}
                                            @if($errors->has('district_id'))
                                                <span class="error invalid-feedback">{{ $errors->first('district_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Desa/Kelurahan', null, ['class' => 'control-label']) !!}
                                            {!! Form::select('sub_district_id',$sub_districts, null, ['class' => "form-control".($errors->has('sub_district_id') ? ' is-invalid' : ''), 'id'=>'sub_district_id','placeholder'=>'Nama Desa/Kelurahan','readonly'=>true]) !!}
                                            @if($errors->has('sub_district_id'))
                                                <span class="error invalid-feedback">{{ $errors->first('sub_district_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group required">
                                            {!! Form::label('RT', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('rt', null, ['class' => "form-control".($errors->has('rt') ? ' is-invalid' : ''), 'id'=>'rt','placeholder'=>'RT','readonly'=>true]) !!}
                                            @if($errors->has('rt'))
                                                <span class="error invalid-feedback">{{ $errors->first('rt') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group required">
                                            {!! Form::label('RW', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('rw', null, ['class' => "form-control".($errors->has('rw') ? ' is-invalid' : ''), 'id'=>'rw','placeholder'=>'RW','readonly'=>true]) !!}
                                            @if($errors->has('rw'))
                                                <span class="error invalid-feedback">{{ $errors->first('rw') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group required">
                                            {!! Form::label('Kode Pos', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('post_code', null, ['class' => "form-control".($errors->has('post_code') ? ' is-invalid' : ''), 'id'=>'post_code','placeholder'=>'Kode Pos','readonly'=>true]) !!}
                                            @if($errors->has('post_code'))
                                                <span class="error invalid-feedback">{{ $errors->first('post_code') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" id="is_domicile" name="is_domicile" value="1" checked>
                                                <label for="is_domicile">Alamat Domisili Sesuai Dengan KTP</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-none" id="domicileSection">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="divider-line"><span>Alamat Domisili</span></div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group required">
                                                    {!! Form::label('Alamat', null, ['class' => 'control-label']) !!}
                                                    {!! Form::textarea('domicile_address', null, ['class' => "form-control map-input".($errors->has('domicile_address') ? ' is-invalid' : ''), 'id'=>'domicile_address','placeholder'=>'Alamat','rows'=>'3','readonly'=>true]) !!}
                                                    @if($errors->has('domicile_address'))
                                                        <span class="error invalid-feedback">{{ $errors->first('domicile_address') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                {!! Form::hidden('domicile_address_latitude', null, ['class' => "form-control", 'id'=>'domicile_address_latitude']) !!}
                                                {!! Form::hidden('domicile_address_longitude', null, ['class' => "form-control", 'id'=>'domicile_address_longitude']) !!}
                                                <div id="address-map-container" style="width:100%;height:400px; ">
                                                    <div style="width: 100%; height: 100%" id="domicile_address_map"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group required">
                                                    {!! Form::label('Provinsi', null, ['class' => 'control-label']) !!}
                                                    {!! Form::select('domicile_province_id',$provinces, null, ['class' => "form-control".($errors->has('domicile_province_id') ? ' is-invalid' : ''), 'id'=>'domicile_province_id','placeholder'=>'Nama Provinsi','readonly'=>true]) !!}
                                                    @if($errors->has('domicile_province_id'))
                                                        <span class="error invalid-feedback">{{ $errors->first('domicile_province_id') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group required">
                                                    {!! Form::label('Kota/Kabupaten', null, ['class' => 'control-label']) !!}
                                                    {!! Form::select('domicile_city_id',$cities, null, ['class' => "form-control".($errors->has('domicile_city_id') ? ' is-invalid' : ''), 'id'=>'domicile_city_id','placeholder'=>'Nama Kota/Kabupaten','readonly'=>true]) !!}
                                                    @if($errors->has('domicile_city_id'))
                                                        <span class="error invalid-feedback">{{ $errors->first('domicile_city_id') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group required">
                                                    {!! Form::label('Kecamatan', null, ['class' => 'control-label']) !!}
                                                    {!! Form::select('domicile_district_id',$districts, null, ['class' => "form-control".($errors->has('domicile_district_id') ? ' is-invalid' : ''), 'id'=>'domicile_district_id','placeholder'=>'Nama Kecamatan','readonly'=>true]) !!}
                                                    @if($errors->has('domicile_district_id'))
                                                        <span class="error invalid-feedback">{{ $errors->first('domicile_district_id') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group required">
                                                    {!! Form::label('Desa/Kelurahan', null, ['class' => 'control-label']) !!}
                                                    {!! Form::select('domicile_sub_district_id',$sub_districts, null, ['class' => "form-control".($errors->has('domicile_sub_district_id') ? ' is-invalid' : ''), 'id'=>'domicile_sub_district_id','placeholder'=>'Nama Desa/Kelurahan','readonly'=>true]) !!}
                                                    @if($errors->has('domicile_sub_district_id'))
                                                        <span class="error invalid-feedback">{{ $errors->first('domicile_sub_district_id') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group required">
                                                    {!! Form::label('RT', null, ['class' => 'control-label']) !!}
                                                    {!! Form::text('domicile_rt', null, ['class' => "form-control".($errors->has('domicile_rt') ? ' is-invalid' : ''), 'id'=>'domicile_rt','placeholder'=>'RT','readonly'=>true]) !!}
                                                    @if($errors->has('domicile_rt'))
                                                        <span class="error invalid-feedback">{{ $errors->first('domicile_rt') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group required">
                                                    {!! Form::label('RW', null, ['class' => 'control-label']) !!}
                                                    {!! Form::text('domicile_rw', null, ['class' => "form-control".($errors->has('domicile_rw') ? ' is-invalid' : ''), 'id'=>'domicile_rw','placeholder'=>'RW','readonly'=>true]) !!}
                                                    @if($errors->has('domicile_rw'))
                                                        <span class="error invalid-feedback">{{ $errors->first('domicile_rw') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group required">
                                                    {!! Form::label('Kode Pos', null, ['class' => 'control-label']) !!}
                                                    {!! Form::text('domicile_post_code', null, ['class' => "form-control".($errors->has('domicile_post_code') ? ' is-invalid' : ''), 'id'=>'domicile_post_code','placeholder'=>'Kode Pos','readonly'=>true]) !!}
                                                    @if($errors->has('domicile_post_code'))
                                                        <span class="error invalid-feedback">{{ $errors->first('domicile_post_code') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Status Rumah', null, ['class' => 'control-label']) !!}
                                            {!! Form::select('residential_status', ['Milik Sendiri'=>'Milik Sendiri','Milik Orang Tua'=>'Milik Orang Tua','Sewa'=>'Sewa','Kos'=>'Kos','Lainnya'=>'Lainnya'],null, ['class' => "form-control".($errors->has('residential_status') ? ' is-invalid' : ''), 'id'=>'residential_status','placeholder'=>'Status Rumah','readonly'=>true]) !!}
                                            @if($errors->has('residential_status'))
                                                <span class="error invalid-feedback">{{ $errors->first('residential_status') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Menempati Tahun', null, ['class' => 'control-label']) !!}
                                            {!! Form::number('occupied_at',null, ['class' => "form-control".($errors->has('occupied_at') ? ' is-invalid' : ''), 'id'=>'occupied_at','placeholder'=>'Menempati Tahun','readonly'=>true]) !!}
                                            @if($errors->has('occupied_at'))
                                                <span class="error invalid-feedback">{{ $errors->first('occupied_at') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Pekerjaan Sekarang', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('current_job', null, ['class' => "form-control".($errors->has('current_job') ? ' is-invalid' : ''), 'id'=>'current_job','placeholder'=>'Pekerjaan Sekarang','readonly'=>true]) !!}
                                            @if($errors->has('current_job'))
                                                <span class="error invalid-feedback">{{ $errors->first('current_job') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Jenis Usaha/Pekerjaan', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('business_type', null, ['class' => "form-control".($errors->has('business_type') ? ' is-invalid' : ''), 'id'=>'business_type','placeholder'=>'Jenis Usaha/Pekerjaan','readonly'=>true]) !!}
                                            @if($errors->has('business_type'))
                                                <span class="error invalid-feedback">{{ $errors->first('business_type') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group required">
                                            {!! Form::label('Alamat Usaha/Pekerjaan', null, ['class' => 'control-label']) !!}
                                            {!! Form::textarea('current_job_address', null, ['class' => "form-control".($errors->has('current_job_address') ? ' is-invalid' : ''), 'id'=>'current_job_address','placeholder'=>'Alamat Usaha/Pekerjaan','rows'=>3,'readonly'=>true]) !!}
                                            @if($errors->has('current_job_address'))
                                                <span class="error invalid-feedback">{{ $errors->first('current_job_address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Status Perkawinan', null, ['class' => 'control-label']) !!}
                                            {!! Form::select('marital_status', ['Kawin'=>'Kawin','Belum Kawin'=>'Belum Kawin','Duda'=>'Duda', 'Janda'=>'Janda'],null, ['class' => "form-control".($errors->has('marital_status') ? ' is-invalid' : ''), 'id'=>'marital_status','placeholder'=>'Status Perkawinan','readonly'=>true]) !!}
                                            @if($errors->has('marital_status'))
                                                <span class="error invalid-feedback">{{ $errors->first('marital_status') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-none" id="spouse">
                                        <div class="row">
                                            <div class="col-md-12"><div class="divider-line"><span>Data Pasangan</span></div></div>
                                            <div class="col-md-6">
                                                <div class="form-group required @error('first_name') has-danger @enderror">
                                                    {!! Form::label('Nama ', null, ['class' => 'control-label']) !!}
                                                    {!! Form::text('spouse_name', null, ['class' => "form-control".($errors->has('spouse_name') ? ' is-invalid' : ''), 'id'=>'spouse_name','placeholder'=>'Nama ','readonly'=>true]) !!}
                                                    @if($errors->has('spouse_name'))
                                                        <span class="error invalid-feedback">{{ $errors->first('spouse_name') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group required @error('first_name') has-danger @enderror">
                                                    {!! Form::label('NIK ', null, ['class' => 'control-label']) !!}
                                                    {!! Form::text('spouse_id_number', null, ['class' => "form-control".($errors->has('spouse_id_number') ? ' is-invalid' : ''), 'id'=>'spouse_id_number','placeholder'=>'Nama','readonly'=>true]) !!}
                                                    @if($errors->has('spouse_id_number'))
                                                        <span class="error invalid-feedback">{{ $errors->first('spouse_id_number') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group required">
                                                    {!! Form::label('Tempat Lahir ', null, ['class' => 'control-label']) !!}
                                                    {!! Form::text('spouse_birth_place', null, ['class' => "form-control".($errors->has('spouse_birth_place') ? ' is-invalid' : ''), 'id'=>'spouse_birth_place','placeholder'=>'Tempat Lahir ','readonly'=>true]) !!}
                                                    @if($errors->has('spouse_birth_place'))
                                                        <span class="error invalid-feedback">{{ $errors->first('spouse_birth_place') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group required">
                                                    {!! Form::label('Tanggal Lahir', null, ['class' => 'control-label']) !!}
                                                    <div class="input-group date" id="spouse_birth_date" data-target-input="nearest">
                                                        {!! Form::text('spouse_birth_date', null, ['class' => 'date-mask form-control datetimepicker-input'.($errors->has('spouse_birth_date') ? ' is-invalid' : ''),'id'=>'sp_birth_date','placeholder'=>'Tanggal Lahir','data-target'=>'#spouse_birth_date','readonly'=>true]) !!}
                                                        <div class="input-group-append" data-target="#spouse_birth_date" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                    @if($errors->has('spouse_birth_date'))
                                                        <span class="error invalid-feedback">{{ $errors->first('spouse_birth_date') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group required">
                                                    {!! Form::label('Pekerjaan', null, ['class' => 'control-label']) !!}
                                                    {!! Form::text('spouse_job', null, ['class' => "form-control".($errors->has('spouse_job') ? ' is-invalid' : ''), 'id'=>'spouse_job','placeholder'=>'Pekerjaan','readonly'=>true]) !!}
                                                    @if($errors->has('spouse_job'))
                                                        <span class="error invalid-feedback">{{ $errors->first('spouse_job') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="divider-line"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-left">
                                            <button class="btn btn-default btn-prev"  type="button" data-prev="#btn-taspen"><i class="fas fa-chevron-left"></i> Sebelumnya</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-right">
                                            <button class="btn btn-success btn-next" data-next="#btn-guarantee" type="button" >Selanjutnya <i class="fas fa-chevron-right"></i> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="guaranteeTab" role="tabpanel" aria-labelledby="contact-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Nama Skep', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('skep_name', null, ['class' => "form-control".($errors->has('skep_name') ? ' is-invalid' : ''), 'id'=>'skep_name','placeholder'=>'Nama SKEP','readonly'=>true]) !!}
                                            @if($errors->has('skep_name'))
                                                <span class="error invalid-feedback">{{ $errors->first('skep_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Nopen', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('nopen', null, ['class' => "form-control".($errors->has('nopen') ? ' is-invalid' : ''), 'id'=>'nopen','placeholder'=>'Nopen','readonly'=>true]) !!}
                                            @if($errors->has('nopen'))
                                                <span class="error invalid-feedback">{{ $errors->first('nopen') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('No. SKEP', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('skep_number', null, ['class' => "form-control".($errors->has('skep_number') ? ' is-invalid' : ''), 'id'=>'skep_number','placeholder'=>'No. Skep','readonly'=>true]) !!}
                                            @if($errors->has('skep_number'))
                                                <span class="error invalid-feedback">{{ $errors->first('skep_number') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Kode Jiwa', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('employee_code', null, ['class' => "form-control".($errors->has('employee_code') ? ' is-invalid' : ''), 'id'=>'employee_code','placeholder'=>'Kode Jiwa','readonly'=>true]) !!}
                                            @if($errors->has('employee_code'))
                                                <span class="error invalid-feedback">{{ $errors->first('employee_code') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Golongan', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('employee_grade', null, ['class' => "form-control".($errors->has('employee_grade') ? ' is-invalid' : ''), 'id'=>'employee_grade','placeholder'=>'Golongan','readonly'=>true]) !!}
                                            @if($errors->has('employee_grade'))
                                                <span class="error invalid-feedback">{{ $errors->first('employee_grade') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Jenis Pensiun', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('retirement_type', null, ['class' => "form-control".($errors->has('retirement_type') ? ' is-invalid' : ''), 'id'=>'retirement_type','placeholder'=>'Jenis Pensiun','readonly'=>true]) !!}
                                            @if($errors->has('retirement_type'))
                                                <span class="error invalid-feedback">{{ $errors->first('retirement_type') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Tanggal SK Pensiun', null, ['class' => 'control-label']) !!}
                                            <div class="input-group date" id="skep_date" data-target-input="nearest">
                                                {!! Form::text('guarantee_skep_date', null, ['class' => 'date-mask form-control datetimepicker-input'.($errors->has('guarantee_skep_date') ? ' is-invalid' : ''),'id'=>'guarantee_skep_date','placeholder'=>'Tanggal Lahir','data-target'=>'#guarantee_skep_date','readonly'=>true]) !!}
                                                <div class="input-group-append" data-target="#skep_date" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                            @if($errors->has('guarantee_skep_date'))
                                                <span class="error invalid-feedback">{{ $errors->first('guarantee_skep_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Penerbit SK', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('guarantee_skep_publisher', null, ['class' => "form-control".($errors->has('guarantee_skep_publisher') ? ' is-invalid' : ''), 'id'=>'guarantee_skep_publisher','placeholder'=>'Penerbit SK','readonly'=>true]) !!}
                                            @if($errors->has('guarantee_skep_publisher'))
                                                <span class="error invalid-feedback">{{ $errors->first('guarantee_skep_publisher') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="divider-line"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-left">
                                            <button class="btn btn-default btn-prev" data-prev="#btn-profile" type="button"><i class="fas fa-chevron-left"></i> Sebelumnya</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-right">
                                            <button class="btn btn-success btn-next" data-next="#btn-product" type="button">Selanjutnya <i class="fas fa-chevron-right"></i> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="productTab" role="tabpanel" aria-labelledby="contact-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="divider-line"><span>Data Penghasilan</span></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {!! Form::label('Juru Bayar Asal', null, ['class' => 'control-label']) !!}
                                                    {!! Form::text('original_paymaster', null, ['class' => "form-control".($errors->has('original_paymaster') ? ' is-invalid' : ''), 'id'=>'original_paymaster','placeholder'=>'Juru Bayar Asal','readonly'=>true]) !!}
                                                    @if($errors->has('original_paymaster'))
                                                        <span class="error invalid-feedback">{{ $errors->first('original_paymaster') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {!! Form::label('Juru Bayar Tujuan', null, ['class' => 'control-label']) !!}
                                                    {!! Form::text('destination_paymaster', null, ['class' => "form-control".($errors->has('destination_paymaster') ? ' is-invalid' : ''), 'id'=>'destination_paymaster','placeholder'=>'Juru Bayar Tujuan','readonly'=>true]) !!}
                                                    @if($errors->has('destination_paymaster'))
                                                        <span class="error invalid-feedback">{{ $errors->first('destination_paymaster') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('Pembiayaan Sebelumnya', null, ['class' => 'control-label']) !!}
                                                    {!! Form::text('previous_loan', null, ['class' => "form-control".($errors->has('previous_loan') ? ' is-invalid' : ''), 'id'=>'previous_loan','placeholder'=>'Pembiayaan Sebelumnya','readonly'=>true]) !!}
                                                    @if($errors->has('previous_loan'))
                                                        <span class="error invalid-feedback">{{ $errors->first('previous_loan') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('Nama Bank', null, ['class' => 'control-label']) !!}
                                                    {!! Form::text('bank_name', null, ['class' => "form-control".($errors->has('bank_name') ? ' is-invalid' : ''), 'id'=>'bank_name','placeholder'=>'Nama Bank','readonly'=>true]) !!}
                                                    @if($errors->has('bank_name'))
                                                        <span class="error invalid-feedback">{{ $errors->first('bank_name') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('No Rekening', null, ['class' => 'control-label']) !!}
                                                    {!! Form::number('account_bank_number', null, ['class' => "form-control".($errors->has('account_bank_number') ? ' is-invalid' : ''), 'id'=>'account_bank_number','placeholder'=>'No Rekening','readonly'=>true,'step'=>'1']) !!}
                                                    @if($errors->has('account_bank_number'))
                                                        <span class="error invalid-feedback">{{ $errors->first('account_bank_number') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group required">
                                                    {!! Form::label('Tanggal Lahir', null, ['class' => 'control-label']) !!}
                                                    <div class="input-group date" id="datetime" data-target-input="nearest">
                                                        {!! Form::text('birth_date', null, ['class' => 'date-mask birth_date form-control datetimepicker-input'.($errors->has('id_number') ? ' is-invalid' : ''), 'id'=>'birth_date','placeholder'=>'Tanggal Lahir','data-target'=>'#datetime','readonly'=>true]) !!}
                                                        <div class="input-group-append" data-target="#datetime" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                    @if($errors->has('birth_date'))
                                                        <span class="error invalid-feedback">{{ $errors->first('birth_date') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-2 offset-md-1">
                                                <div class="form-group">
                                                    {!! Form::label('Usia', null, ['class' => 'control-label']) !!}
                                                    {!! Form::text('year', null, ['class' => "form-control".($errors->has('year') ? ' is-invalid' : ''), 'id'=>'year','placeholder'=>'Usia','readonly'=>true]) !!}
                                                    @if($errors->has('year'))
                                                        <span class="error invalid-feedback">{{ $errors->first('year') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {!! Form::label('Bulan', null, ['class' => 'control-label']) !!}
                                                    {!! Form::text('month', null, ['class' => "form-control".($errors->has('month') ? ' is-invalid' : ''), 'id'=>'month','placeholder'=>'Month','readonly'=>true]) !!}
                                                    @if($errors->has('month'))
                                                        <span class="error invalid-feedback">{{ $errors->first('month') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    {!! Form::label('Hari', null, ['class' => 'control-label']) !!}
                                                    {!! Form::text('day', null, ['class' => "form-control".($errors->has('day') ? ' is-invalid' : ''), 'id'=>'day','placeholder'=>'Hari','readonly'=>true]) !!}
                                                    @if($errors->has('day'))
                                                        <span class="error invalid-feedback">{{ $errors->first('day') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group required">
                                                    {!! Form::label('Gaji Bersih', null, ['class' => 'control-label']) !!}
                                                    {!! Form::text('salary', null, ['class' => "currency-mask form-control".($errors->has('salary') ? ' is-invalid' : ''), 'id'=>'salary','placeholder'=>'Gaji Bersih','readonly'=>true]) !!}
                                                    @if($errors->has('salary'))
                                                        <span class="error invalid-feedback">{{ $errors->first('salary') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group required">
                                                    {!! Form::label('Produk Pembiayaan', null, ['class' => 'control-label']) !!}
                                                    {!! Form::select('product_id', $products,null, ['class' => "form-control".($errors->has('product_id') ? ' is-invalid' : ''), 'id'=>'product_id','readonly'=>true]) !!}
                                                    @if($errors->has('product_id'))
                                                        <span class="error invalid-feedback">{{ $errors->first('product_id') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group required">
                                                    {!! Form::label('Jenis Pembiayaan', null, ['class' => 'control-label']) !!}
                                                    {!! Form::select('finance_type_id', $types, null, ['class' => "form-control".($errors->has('finance_type_id') ? ' is-invalid' : ''), 'id'=>'finance_type_id','placeholder'=>'Jenis Pembiayaan','readonly'=>true]) !!}
                                                    @if($errors->has('finance_type_id'))
                                                        <span class="error invalid-feedback">{{ $errors->first('finance_type_id') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group required">
                                                    {!! Form::label('Jenis Bunga', null, ['class' => 'control-label']) !!}
                                                    {!! Form::select('interest_type', ['flat'=>'Flat','anuitas'=>'Anuitas'], null, ['class' => "form-control".($errors->has('interest_type') ? ' is-invalid' : ''), 'id'=>'interest_type','placeholder'=>'Jenis Bunga','readonly'=>true]) !!}
                                                    @if($errors->has('interest_type'))
                                                        <span class="error invalid-feedback">{{ $errors->first('interest_type') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group required">
                                                    {!! Form::label('Referral', null, ['class' => 'control-label']) !!}
                                                    {!! Form::select('referral_id', $referral, null, ['class' => "form-control".($errors->has('referral_id') ? ' is-invalid' : ''), 'id'=>'referral_id','placeholder'=>'Referral','readonly'=>true]) !!}
                                                    @if($errors->has('referral_id'))
                                                        <span class="error invalid-feedback">{{ $errors->first('referral_id') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group required">
                                                    {!! Form::label('Referral Fee (%)', null, ['class' => 'control-label']) !!}
                                                    {!! Form::number('referral_fee', null, ['class' => "form-control".($errors->has('referral_fee') ? ' is-invalid' : ''), 'id'=>'referral_fee','placeholder'=>'Referral Fee','readonly'=>true, 'step'=>'0.01']) !!}
                                                    @if($errors->has('referral_fee'))
                                                        <span class="error invalid-feedback">{{ $errors->first('referral_id') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group required">
                                                    {!! Form::label('Tujuan Penggunaan', null, ['class' => 'control-label']) !!}
                                                    {!! Form::textarea('purpose', null, ['class' => "form-control".($errors->has('purpose') ? ' is-invalid' : ''), 'id'=>'purpose','placeholder'=>'Tujuan Penggunaan', 'rows'=>'2']) !!}
                                                    @if($errors->has('purpose'))
                                                        <span class="error invalid-feedback">{{ $errors->first('referral_id') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="divider-line"><span>Rekomendasi</span></div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('Tenor', null, ['class' => 'control-label']) !!}
                                                    {!! Form::number('tenor', null, ['class' => "form-control".($errors->has('tenor') ? ' is-invalid' : ''), 'id'=>'tenor','placeholder'=>'Tenor', 'readonly'=>true]) !!}
                                                    @if($errors->has('tenor'))
                                                        <span class="error invalid-feedback">{{ $errors->first('tenor') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('Max Tenor', null, ['class' => 'control-label']) !!}
                                                    {!! Form::number('max_tenor', null, ['class' => "form-control".($errors->has('max_tenor') ? ' is-invalid' : ''), 'id'=>'max_tenor','placeholder'=>'Max Tenor', 'readonly'=>true]) !!}
                                                    @if($errors->has('max_tenor'))
                                                        <span class="error invalid-feedback">{{ $errors->first('max_tenor') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('Max Angsuran', null, ['class' => 'control-label']) !!}
                                                    {!! Form::text('max_installment', null, ['class' => "currency-mask form-control".($errors->has('max_installment') ? ' is-invalid' : ''), 'id'=>'max_installment','placeholder'=>'Max Angsuran', 'readonly'=>true]) !!}
                                                    @if($errors->has('max_installment'))
                                                        <span class="error invalid-feedback">{{ $errors->first('max_installment') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('Plafon', null, ['class' => 'control-label']) !!}
                                                    {!! Form::text('plafon', null, ['class' => "currency-mask form-control".($errors->has('plafon') ? ' is-invalid' : ''), 'id'=>'plafon','placeholder'=>'Plafon', 'readonly'=>true]) !!}
                                                    @if($errors->has('plafon'))
                                                        <span class="error invalid-feedback">{{ $errors->first('plafon') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('Max Plafon', null, ['class' => 'control-label']) !!}
                                                    {!! Form::text('max_plafon', null, ['class' => "currency-mask form-control".($errors->has('max_plafon') ? ' is-invalid' : ''), 'id'=>'max_plafon','placeholder'=>'Max Plafon', 'readonly'=>true]) !!}
                                                    @if($errors->has('max_plafon'))
                                                        <span class="error invalid-feedback">{{ $errors->first('max_plafon') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {!! Form::label('installment', null, ['class' => 'control-label']) !!}
                                                    {!! Form::text('installment', null, ['class' => "currency-mask form-control".($errors->has('installment') ? ' is-invalid' : ''), 'id'=>'installment','placeholder'=>'installment', 'readonly'=>true]) !!}
                                                    @if($errors->has('installment'))
                                                        <span class="error invalid-feedback">{{ $errors->first('installment') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card card-warning">
                                            <div class="card-header with-border">
                                                <h3 class="card-title">Keterangan</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            {!! Form::label('Administrasi', null, ['class' => 'control-label']) !!}
                                                            <p class="help-block">Biaya Administrasi</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group required">
                                                            {!! Form::text('administration_fee', null, ['class' => "currency-mask form-control".($errors->has('administration_fee') ? ' is-invalid' : ''), 'id'=>'administration_fee','placeholder'=>'0', 'readonly'=>true]) !!}
                                                            @if($errors->has('administration_fee'))
                                                                    <span class="error invalid-feedback">{{ $errors->first('administration_fee') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            {!! Form::label('Tatalaksana', null, ['class' => 'control-label']) !!}
                                                            <p class="help-block">Biaya Tatalaksana</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group required">
                                                            {!! Form::text('management_fee', null, ['class' => "currency-mask form-control".($errors->has('management_fee') ? ' is-invalid' : ''), 'id'=>'management_fee','placeholder'=>'0', 'readonly'=>true]) !!}
                                                            @if($errors->has('management_fee'))
                                                                    <span class="error invalid-feedback">{{ $errors->first('management_fee') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            {!! Form::label('Asuransi', null, ['class' => 'control-label']) !!}
                                                            <p class="help-block">Biaya Asuransi (Non BPP)</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group required">
                                                            {!! Form::text('insurance_fee', null, ['class' => "currency-mask form-control".($errors->has('insurance_fee') ? ' is-invalid' : ''), 'id'=>'insurance_fee','placeholder'=>'0', 'readonly'=>true]) !!}
                                                            @if($errors->has('insurance_fee'))
                                                                    <span class="error invalid-feedback">{{ $errors->first('insurance_fee') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            {!! Form::label('Buka Rekening', null, ['class' => 'control-label']) !!}
                                                            <p class="help-block">Biaya Buka Rekening</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group required">
                                                            {!! Form::text('account_opening_fee', null, ['class' => "currency-mask form-control".($errors->has('account_opening_fee') ? ' is-invalid' : ''), 'id'=>'account_opening_fee','placeholder'=>'0', 'readonly'=>true]) !!}
                                                            @if($errors->has('account_opening_fee'))
                                                                    <span class="error invalid-feedback">{{ $errors->first('account_opening_fee') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            {!! Form::label('Materai', null, ['class' => 'control-label']) !!}
                                                            <p class="help-block">Biaya Materai</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group required">
                                                            {!! Form::text('stamp_fee', null, ['class' => "currency-mask form-control".($errors->has('stamp_fee') ? ' is-invalid' : ''), 'id'=>'stamp_fee', 'readonly'=>'true']) !!}
                                                            @if($errors->has('stamp_fee'))
                                                                    <span class="error invalid-feedback">{{ $errors->first('stamp_fee') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            {!! Form::label('Data Informasi', null, ['class' => 'control-label']) !!}
                                                            <p class="help-block">Biaya Data Informasi</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group required">
                                                            {!! Form::text('information_fee', null, ['class' => "currency-mask form-control".($errors->has('information_fee') ? ' is-invalid' : ''), 'id'=>'information_fee','placeholder'=>'0', 'readonly'=>true]) !!}
                                                            @if($errors->has('information_fee'))
                                                                    <span class="error invalid-feedback">{{ $errors->first('information_fee') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            {!! Form::label('Mutasi', null, ['class' => 'control-label']) !!}
                                                            <p class="help-block">Biaya Mutasi</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group required">
                                                            {!! Form::text('mutation_fee', null, ['class' => "currency-mask form-control".($errors->has('mutation_fee') ? ' is-invalid' : ''), 'id'=>'mutation_fee','placeholder'=>'0', 'readonly'=>true]) !!}
                                                            @if($errors->has('mutation_fee'))
                                                                    <span class="error invalid-feedback">{{ $errors->first('mutation_fee') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            {!! Form::label('Provisi', null, ['class' => 'control-label']) !!}
                                                            <p class="help-block">Biaya Provisi</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group required">
                                                            {!! Form::text('provision_fee', null, ['class' => "currency-mask form-control".($errors->has('provision_fee') ? ' is-invalid' : ''), 'id'=>'provision_fee','placeholder'=>'0', 'readonly'=>true]) !!}
                                                            @if($errors->has('provision_fee'))
                                                                    <span class="error invalid-feedback">{{ $errors->first('provision_fee') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            {!! Form::label('Blokir', null, ['class' => 'control-label']) !!}
                                                            <p class="help-block">Jumlah Angsuran</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group required">
                                                            {!! Form::number('block_installment', null, ['class' => "form-control".($errors->has('block_installment') ? ' is-invalid' : ''), 'id'=>'block_installment','placeholder'=>'0', 'readonly'=>true,'step'=>'1']) !!}
                                                            @if($errors->has('block_installment'))
                                                                    <span class="error invalid-feedback">{{ $errors->first('block_installment') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            {!! Form::label('Blokir Angsuran', null, ['class' => 'control-label']) !!}
                                                            <p class="help-block">Jumlah Blokir</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group required">
                                                            {!! Form::text('blockir_fee', null, ['class' => "currency-mask form-control".($errors->has('blockir_fee') ? ' is-invalid' : ''), 'id'=>'blockir_fee','placeholder'=>'0', 'readonly'=>true]) !!}
                                                            @if($errors->has('blockir_fee'))
                                                                    <span class="error invalid-feedback">{{ $errors->first('blockir_fee') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            {!! Form::label('Terima Kotor', null, ['class' => 'control-label']) !!}
                                                            <p class="help-block">Jumlah Terima Kotor</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group required">
                                                            {!! Form::text('gross_amount', null, ['class' => "currency-mask form-control".($errors->has('gross_amount') ? ' is-invalid' : ''), 'id'=>'gross_amount','placeholder'=>'0', 'readonly'=>true]) !!}
                                                            @if($errors->has('gross_amount'))
                                                                    <span class="error invalid-feedback">{{ $errors->first('gross_amount') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            {!! Form::label('BPP', null, ['class' => 'control-label text-red']) !!}
                                                            <p class="help-block">Nominal BPP</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group required">
                                                            {!! Form::text('bpp_fee', null, ['class' => "currency-mask form-control".($errors->has('bpp_fee') ? ' is-invalid' : ''), 'id'=>'bpp_fee','placeholder'=>'0', 'readonly'=>true]) !!}
                                                            @if($errors->has('bpp_fee'))
                                                                    <span class="error invalid-feedback">{{ $errors->first('bpp_fee') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            {!! Form::label('Nominal Pelunasan', null, ['class' => 'control-label']) !!}
                                                            <p class="help-block">Nominal Pelunasan</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group required">
                                                            {!! Form::text('repayment_fee', null, ['class' => "currency-mask form-control".($errors->has('repayment_fee') ? ' is-invalid' : ''), 'id'=>'repayment_fee','placeholder'=>'0', 'readonly'=>true]) !!}
                                                            @if($errors->has('repayment_fee'))
                                                                    <span class="error invalid-feedback">{{ $errors->first('repayment_fee') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            {!! Form::label('Terima Bersih', null, ['class' => 'control-label']) !!}
                                                            <p class="help-block">Jumlah Terima Bersih</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group required">
                                                            {!! Form::text('net_amount', null, ['class' => "currency-mask form-control".($errors->has('net_amount') ? ' is-invalid' : ''), 'id'=>'net_amount','placeholder'=>'0', 'readonly'=>true]) !!}
                                                            @if($errors->has('net_amount'))
                                                                    <span class="error invalid-feedback">{{ $errors->first('net_amount') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            {!! Form::label('Sisa Gaji', null, ['class' => 'control-label']) !!}
                                                            <p class="help-block">Jumlah Sisa Gaji Setiap Bulan</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group required">
                                                            {!! Form::text('rest_salary', null, ['class' => "currency-mask form-control".($errors->has('rest_salary') ? ' is-invalid' : ''), 'id'=>'rest_salary','placeholder'=>'0', 'readonly'=>true]) !!}
                                                            @if($errors->has('rest_salary'))
                                                                    <span class="error invalid-feedback">{{ $errors->first('rest_salary') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    {!! Form::hidden('round_off', null, ['class' => "form-control", 'id'=>'round_off']) !!}
                                                    {!! Form::hidden('interest', null, ['class' => "form-control", 'id'=>'interest']) !!}
                                                    {!! Form::hidden('epotpen_fee', null, ['class' => "form-control", 'id'=>'epotpen_fee']) !!}
                                                    {!! Form::hidden('flagging_fee', null, ['class' => "form-control", 'id'=>'flagging_fee']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="divider-line"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-left">
                                        <button class="btn btn-default btn-prev" data-prev="#btn-guarantee" type="button"><i class="fas fa-chevron-left"></i> Sebelumnya</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-right">
                                            <button class="btn btn-success btn-next" data-next="#btn-service" type="button">Selanjutnya <i class="fas fa-chevron-right"></i> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="serviceUnit" role="tabpanel" aria-labelledby="serviceUnit">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="divider-line"><span>Unit Pelayanan</span></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Unit Layanan', null, ['class' => 'control-label']) !!}
                                            {!! Form::select('service_unit_id',$service_units, null, ['class' => "form-control".($errors->has('service_unit_id') ? ' is-invalid' : ''), 'id'=>'service_unit_id','placeholder'=>'Unit Pelayanan']) !!}
                                            @if($errors->has('service_unit_id'))
                                                <span class="error invalid-feedback">{{ $errors->first('service_unit_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Unit Cabang', null, ['class' => 'control-label']) !!}
                                            {!! Form::select('branch_unit_id',$branch_units, null, ['class' => "form-control".($errors->has('branch_unit_id') ? ' is-invalid' : ''), 'id'=>'branch_unit_id','placeholder'=>'Unit Cabang','readonly'=>true]) !!}
                                            @if($errors->has('branch_unit_id'))
                                                <span class="error invalid-feedback">{{ $errors->first('branch_unit_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Nama Marketing', null, ['class' => 'control-label']) !!}
                                            {!! Form::select('marketing_id',$marketings, null, ['class' => "form-control".($errors->has('marketing_id') ? ' is-invalid' : ''), 'id'=>'marketing_id','placeholder'=>'Nama Marketing','readonly'=>true]) !!}
                                            @if($errors->has('marketing_id'))
                                                <span class="error invalid-feedback">{{ $errors->first('marketing_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Posisi', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('job_position', null, ['class' => "form-control".($errors->has('job_position') ? ' is-invalid' : ''), 'id'=>'job_position','placeholder'=>'Posisi','readonly'=>true]) !!}
                                            @if($errors->has('job_position'))
                                                <span class="error invalid-feedback">{{ $errors->first('job_position') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Status PKWT', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('pkwt_status', null, ['class' => "form-control".($errors->has('pkwt_status') ? ' is-invalid' : ''), 'id'=>'pkwt_status','placeholder'=>'Status PKWT','readonly'=>true]) !!}
                                            @if($errors->has('pkwt_status'))
                                                <span class="error invalid-feedback">{{ $errors->first('pkwt_status') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Agen Fronting', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('fronting_agent', null, ['class' => "form-control".($errors->has('fronting_agent') ? ' is-invalid' : ''), 'id'=>'fronting_agent','placeholder'=>'Agen Fronting','readonly'=>true]) !!}
                                            @if($errors->has('fronting_agent'))
                                                <span class="error invalid-feedback">{{ $errors->first('fronting_agent') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row file-section-upload d-none">
                                            <div class="col-md-12">
                                                <div class="divider-line"><span>Berkas Pengajuan</span></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group required">
                                                    {!! Form::label('Berkas Slik (PDF)', null, ['class' => 'control-label']) !!}
                                                    {!! Form::file('slik_file',  ['class' => "form-control".($errors->has('slik_file') ? ' is-invalid' : ''), 'id'=>'slik_file','accept'=>"application/pdf",'aria-describedby'=>"slikHelp"]) !!}
                                                    <!-- <small id="slikHelp" class="form-text text-muted">Pdf</small> -->
                                                    @if($errors->has('slik_file'))
                                                        <span class="error invalid-feedback">{{ $errors->first('slik_file') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group required">
                                                    {!! Form::label('Berkas Pengajuan  (PDF)', null, ['class' => 'control-label']) !!}
                                                    {!! Form::file('application_file', ['class' => "form-control".($errors->has('application_file') ? ' is-invalid' : ''), 'id'=>'application_file','accept'=>"application/pdf"]) !!}
                                                    @if($errors->has('application_file'))
                                                        <span class="error invalid-feedback">{{ $errors->first('application_file') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group required">
                                                    {!! Form::label('Video Wawancara', null, ['class' => 'control-label']) !!}
                                                    {!! Form::file('interview_video', ['class' => "form-control".($errors->has('interview_video') ? ' is-invalid' : ''), 'id'=>'interview_video','accept'=>"video/*"]) !!}
                                                    @if($errors->has('interview_video'))
                                                        <span class="error invalid-feedback">{{ $errors->first('interview_video') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group required">
                                                    {!! Form::label('Video Asuransi', null, ['class' => 'control-label']) !!}
                                                    {!! Form::file('insurance_video', ['class' => "form-control".($errors->has('insurance_video') ? ' is-invalid' : ''), 'id'=>'insurance_video','accept'=>"video/*"]) !!}
                                                    @if($errors->has('insurance_video'))
                                                        <span class="error invalid-feedback">{{ $errors->first('insurance_video') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="divider-line"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-left">
                                            <button class="btn btn-default btn-prev" data-prev="#btn-product" type="button"><i class="fas fa-chevron-left"></i> Sebelumnya</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-right">
                                            @if($data->status=='pending' || $data->status == 'queue' || $data->status == '')
                                                @if(check_access('approval_bank','approve'))
                                                <button type="button" class="btn btn-danger" id="btn-reject" name="btn-reject" value="reject"><i class="fas fa-times"></i> Tolak</button>
                                                <button type="button" class="btn btn-warning" id="btn-pending" name="btn-pending" value="pending"><i class="fas fa-clock"></i> Tunda</button>
                                                <button type="button" class="btn btn-success" id="btn-approve" name="btn-approve" value="approve"><i class="fas fa-check"></i> Setuju</button>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            {!! Form::close() !!}
        </div>
        <!-- /.card -->
    </div>
    <!--/.col (left) -->
    <!-- right column -->
    <div class="col-sm-6 col-md-6">
        <div class="card" style="position: fixed;">
            <div class="card-body">
                <div class="row">
                    <ul class="nav nav-tabs" id="myTab2" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="btn-service" data-toggle="tab" data-target="#documents" type="button" role="tab" aria-controls="documents" aria-selected="false">Dokumen Pengajuan</button>
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <div class="tab-content col-md-12" id="myTabContent2">
                        <div class="tab-pane fade show active" id="documents" role="tabpanel" aria-labelledby="documents">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="divider-line"><span>Dokumen Pengajuan</span></div>
                                </div>
                                <div class="col-md-12">
                                    @include('partials.document-files', ['documents'=>$data->documents])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/.col (right) -->
</div>

@endsection

@push('script')
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script>
    var tempBank=null;
    var tempProduct=null;
    var tempType=null;
    var taspenId = "{!!$data->taspen_id !!}"
    var serviceUnitId = "{!! $data->service_unit_id !!}"
    var financeTypeId = "{!! $data->finance_type_id !!}"

    $(function () {
        getTaspen(taspenId)
        readOnlyMode(true)

        $('#birth_date').datetimepicker({
            format: 'DD-MM-YYYY'
        })

        $('#skep_date').datetimepicker({
            format: 'DD-MM-YYYY'
        })
        $('#spouse_birth_date').datetimepicker({
            format: 'DD-MM-YYYY'
        })
        $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })

        $('#province_id').change(function() {
            var id = $(this).val();
            getCity(id,'#city_id')
        });

        $('#city_id').change(function() {
            var id = $(this).val();
            getDistrict(id, "#district_id")
        });

        $('#district_id').change(function() {
            var id = $(this).val();
            getSubDistrict(id, "#sub_district_id")
        });

        $('#domicile_province_id').change(function() {
            var id = $(this).val();
            getCity(id,'#domicile_city_id')
        });

        $('#domicile_city_id').change(function() {
            var id = $(this).val();
            getDistrict(id, "#domicile_district_id")
        });

        $('#domicile_district_id').change(function() {
            var id = $(this).val();
            getSubDistrict(id, "#domicile_sub_district_id")
        });

        $('#is_domicile').click(function(){
            if($(this).val()=='1'){
                $('#domicileSection').removeClass('d-none');
                $(this).val('0')
                $(this).attr('checked',false)
            }else{
                $('#domicileSection').removeClass('d-none');
                $('#domicileSection').addClass('d-none');
                $(this).val('1')
                $(this).attr('checked',true)
            }
        })

        $('#marital_status').change(function(){
            if($(this).val()=='Kawin'){
                $('#spouse').removeClass('d-none');
            }else{
                $('#spouse').removeClass('d-none');
                $('#spouse').addClass('d-none');
            }
        })
        $('#datetime').datetimepicker({
            format: 'DD-MM-YYYY'
        })

        getType()

        $("#datetime").on("change.datetimepicker", ({ date, oldDate }) => {
            var today = moment();
            var birthDate = date;

            var years = today.diff(birthDate, 'year');
            birthDate.add(years, 'years');
            var months = today.diff(birthDate, 'months');
            birthDate.add(months, 'months');
            var days = today.diff(birthDate, 'days');

            $('#year').val(years)
            $('#month').val(months)
            $('#day').val(days)
            $('#salary').attr('readonly', false)
        });

        $("#product_id").on('change', function(){
            var element = $(this).find('option:selected')
            var data = JSON.parse(element.attr("data"))
            var bank = data.bank;
            tempProduct = data
            tempBank = bank
            var year = parseInt($('#year').val())
            var month = parseInt($('#month').val())
            var maxTenor = countMaxTenor(year, month)
            var salary = parseInt($("#salary").val()) || 0
            var maxInstallment = parseInt(salary)*(bank.installment_fee/100)
            var infoFee=parseInt(bank.epotpen_fee)+parseInt(bank.flagging_fee)

            $("#epotpen_fee").val(bank.epotpen)
            $("#flagging_fee").val(bank.flagging_fee)
            $("#max_installment").val(maxInstallment)
            $("#max_tenor").val(maxTenor)
            $("#account_opening_fee").val(parseInt(bank.account_opening_fee))
            $("#stamp_fee").val(parseInt(bank.stamp_fee))
            // $("#plafon").attr('readonly',false)
            // $("#tenor").attr('readonly',false)
            $("#tenor").attr({
                "max" : maxTenor,
                "min" : 1,
                'readonly': false
            });
            $('#information_fee').val(infoFee)
            $('#round_off').val(tempBank.round_off)
            $('#interest').val(tempProduct.interest)
        });

        $("#tenor").on('keyup', function(e){
            var interest = tempProduct.interest/100
            var monthlyInterest = interest/12
            var maxPlafon = PV(monthlyInterest,$("#tenor").val(), parseInt($("#max_installment").val()))
            $("#max_plafon").val(maxPlafon)
            $("#plafon").attr({
                "max" : maxPlafon,
                "min" : 1,
                'readonly': false
            });
        });

        $("#finance_type_id").on('change', function(){
            var element = $(this).find('option:selected')
            var data = JSON.parse(element.attr("data"))
            tempType = data
            $('#mutation_fee').val(data.mutation_fee)
            $('#interest_type').attr('readonly', false)
            $('#referral_id').attr('readonly', false)
        });

        $("#referral_id").on('change', function(){
            $('#referral_fee').attr('readonly', false)
        });

        $("#plafon").on('keyup', function(e){
            var interest = tempProduct.interest/100
            var monthlyInterest = interest/12

            var plafon = parseInt(e.target.value)
            var tenor = $('#tenor').val()
            var angsuran = pmt(monthlyInterest, tenor, plafon, tempBank.round_off)
            var restSalary = parseInt($("#salary").val()) - angsuran
            $("#installment").val(angsuran)
            $("#rest_salary").val(restSalary)
            calculateResults()
        });

        $("#block_installment").on('keyup', function(e){
            var installment = $("#installment").val() || 0
            var blockirFee = parseInt(e.target.value) * parseInt(installment);
            $('#blockir_fee').val(blockirFee)
            calculateResults()
        });

        $("#salary").on('keyup', function(e){
            getProduct($('#year').val())
        });

        $("#repayment_fee").on('keyup', function(e){
            calculateResults()
        });

        $("#bpp_fee").on('keyup', function(e){
            calculateResults()
        });

        $("#taspen_id").on("change", function(e){
            getTaspen(e.target.value)

        })

        $('#service_unit_id').change(function() {
            var id = $(this).val();
            getBranchUnit(id)
        });
        $('#branch_unit_id').change(function() {
            var id = $(this).val();
            getMarketing(id)
        });
        $('#marketing_id').change(function() {
            var element = $(this).find('option:selected')
            var position = element.attr("data-position")
            var status = element.attr("data-status")
            $('#job_position').val(position);
            $('#pkwt_status').val(status);
        });

        $('.btn-next').on("click",function() {
            console.log('aaaaaaaaaaa');
            var element = $(this)
            var next = element.attr("data-next")
            $(next).trigger("click");
        });

        $('.btn-prev').on("click",function() {
            console.log('bbbbbbbbbbb');
            var element = $(this)
            var prev = element.attr("data-prev")
            $(prev).trigger("click");
        });

        $('#btn-approve').on("click",function() {
            $('#btn-reject').attr('disabled', true);
            $('#btn-pending').attr('disabled', true);
            $('#btn-approve').attr('disabled', true);
            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Apakah Anda Yakin, Silahkan Isi Deskripsi!",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "<i class='fa fa-check'></i>&nbsp;Lanjutkan",
                cancelButtonText: "<i class='fa fa-times'></i>&nbsp;Batal",
                inputLabel:"Keterangan",
                input: "textarea",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    approveReject('approve', result.value)
                }
            });
        });

        $('#btn-pending').on("click",function() {
            $('#btn-reject').attr('disabled', true);
            $('#btn-pending').attr('disabled', true);
            $('#btn-approve').attr('disabled', true);
            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Apakah Anda Yakin, Silahkan Isi Deskripsi!",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "<i class='fa fa-check'></i>&nbsp;Lanjutkan",
                cancelButtonText: "<i class='fa fa-times'></i>&nbsp;Batal",
                inputLabel:"Keterangan",
                input: "textarea",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    approveReject('pending', result.value)
                }
            });
        });

        $('#btn-reject').on("click",function() {
            $('#btn-reject').attr('disabled', true);
            $('#btn-pending').attr('disabled', true);
            $('#btn-approve').attr('disabled', true);
            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Apakah Anda Yakin, Silahkan Isi Deskripsi!",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "<i class='fa fa-check'></i>&nbsp;Lanjutkan",
                cancelButtonText: "<i class='fa fa-times'></i>&nbsp;Batal",
                inputLabel:"Keterangan",
                input: "textarea",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    approveReject('reject', result.value)
                }
            });
        });

    })

    function getProduct(age){
        $.ajax({
            url: "{!! route('master-data.dropdown.product') !!}",
            type: "post",
            data: {
                _token: "{{ csrf_token() }}",
                age:age,
            },
            success: function (response) {
                var data = response
                $('#product_id').empty();
                $('#product_id').append($('<option>').text('Please Select').attr('value', '').attr('maxtenor', ''));
                $.each(data, function(key, value) {
                    $('#product_id').append($('<option>').text(value.name).attr('value', value.id).attr('maxtenor', value.max_tenor).attr('maxplafon', value.max_plafon).attr('data',JSON.stringify(value)));
                });
                $('#product_id').attr('disabled', false).attr('readonly', false);
                $('#interest_type').attr('disabled', false).attr('readonly', false)
                $('#referral_id').attr('disabled', false).attr('readonly', false)
            }
        });
    }

    function getType(){
        $.ajax({
            url: "{!! route('master-data.dropdown.finance') !!}",
            type: "post",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                var data = response
                $('#finance_type_id').empty();
                $('#finance_type_id').append($('<option>').text('Please Select').attr('value', '').attr('maxtenor', ''));
                $.each(data, function(key, value) {
                    if(financeTypeId==value.id){
                        $('#finance_type_id').append($('<option>').text(value.name).attr('value', value.id).attr('data',JSON.stringify(value)).attr('selected',true));
                    }else{
                        $('#finance_type_id').append($('<option>').text(value.name).attr('value', value.id).attr('data',JSON.stringify(value)));
                    }
                });
                $('#finance_type_id').attr('disabled', false).attr('readonly', false);
            }
        });
    }

    function resetForm(){
        $('form').trigger("reset")
        $('form select').trigger("change")
        tempBank=null;
        tempProduct=null;
        tempType=null;
    }

    function calculateResults(){
        var plafon = $('#plafon').val() || 0;
        plafon = parseInt(plafon)
        countAdminFee(plafon)
        countManagementFee(plafon)
        countInsurance(plafon)
        countProvision(plafon)
        var administration_fee = $('#administration_fee').val() || 0;
        var management_fee = $('#management_fee').val() || 0;
        var insurance_fee = $('#insurance_fee').val() || 0;
        var account_opening_fee = $('#account_opening_fee').val() || 0;
        var stamp_fee = $('#stamp_fee').val() || 0;
        var by_info = $('#information_fee').val() || 0;
        var mutation_fee = $('#mutation_fee').val() || 0;
        var provision_fee = $('#provision_fee').val() || 0;
        var block_installment = $('#blockir_fee').val() || 0;

        var deduction = parseInt(administration_fee)+parseInt(management_fee)+parseInt(insurance_fee)+parseInt(account_opening_fee)+parseInt(stamp_fee)+parseInt(by_info)+parseInt(mutation_fee)+parseInt(provision_fee)+parseInt(block_installment)
        var gross_amount = plafon-deduction
        var repayment_fee = $('#repayment_fee').val() || 0
        var bpp_fee = $('#bpp_fee').val() || 0
        var net_amount = plafon-deduction-parseInt(repayment_fee)-parseInt(bpp_fee)
        $('#gross_amount').val(gross_amount)
        $('#net_amount').val(net_amount)
        $("#block_installment").attr('readonly', false)
        $("#bpp_fee").attr('readonly', false)
        $("#repayment_fee").attr('readonly', false)

        $('#service_unit_id').attr('readonly',false).attr('disabled', false)
        // $('#branch_unit_id').attr('readonly',false).attr('disabled', false)
        // $('#marketing_id').attr('readonly',false).attr('disabled', false)

    }

    function pmt(interest,tenor, amount, round_off){
        let pmt = Math.abs(interest * (amount * (Math.pow((1 + interest), tenor) / (1 - Math.pow((1 + interest), tenor)))));
        return Math.ceil(pmt/round_off)*round_off;
    }

    function PV(rate, periods, payment, future = 0, type = 0) {
        rate = eval(rate);
        periods = eval(periods);
        var result = Math.abs((((1 - Math.pow(1 + rate, periods)) / rate) * payment * (1 +rate * type) - future) / Math.pow(1 + rate, periods));
        return Math.round(result);
    }

    function countMaxTenor(year, month){
        var maxTenor = tempProduct.max_tenor
        if(((tempProduct.max_paid_age-year)*12)-(month+1) <= maxTenor){
            maxTenor = ((tempProduct.max_paid_age-year)*12)-(month+1)
        }
        return maxTenor
    }
    function countMaxPlafon(year, month){
        var maxTenor = tempProduct.max_tenor
        if(((tempProduct.max_paid_age-year)*12)-(month+1) <= maxTenor){
            maxTenor = ((tempProduct.max_paid_age-year)*12)-(month+1)
        }
        return maxTenor
    }

    function countAdminFee(plafon){
        var totalFee = (parseFloat(tempBank.administration_fee)+parseFloat(tempBank.coop_fee))/100
        var result = plafon*totalFee
        $('#administration_fee').val(result);
    }

    function countManagementFee(plafon){
        var result = parseInt(tempBank.management_fee)
        if(tempBank.is_flash==1){
            result= plafon*(3/100)
        }

        $('#management_fee').val(result);
    }

    function countInsurance(plafon){
        var result = (tempProduct.insurance_fee/100)*plafon
        $('#insurance_fee').val(result);
    }
    function countProvision(plafon){
        var result = (tempBank.provision_fee/100)*plafon
        $('#provision_fee').val(result);
    }

    function capture(nodeId) {
        $('.btn-capture').addClass('invisible')
        const captureElement = document.querySelector('#'+nodeId)
        html2canvas(captureElement)
        .then(canvas => {
            console.log('here');
            canvas.style.display = 'none'
            document.body.appendChild(canvas)
            return canvas
        })
        .then(canvas => {
            console.log('here2');
            const image = canvas.toDataURL('image/png').replace('image/png', 'image/octet-stream')
            const a = document.createElement('a')
            a.setAttribute('download', 'form-simulasi.png')
            a.setAttribute('href', image)
            a.click()
            canvas.remove()
        })
        $('.btn-capture').removeClass('invisible')
    }

    function getTaspen(id){
        $.ajax({
            url: "{!! route('master-data.taspen.detail') !!}",
            type: "post",
            data: {
                _token: "{{ csrf_token() }}",
                id : id
            },
            success: function (response) {
                var data = response.data
                $('#skep_name').val(data.skep_name)
                $('#nopen').val(data.nopen)
                $('#skep_number').val(data.skep_number)
                $('#employee_code').val(data.employee_code)
                $('#employee_grade').val(data.employee_grade)
                $('#retirement_type').val(data.retirement_type)
                $('#name').val(data.name)
                $('#id_number').val(data.id_number)
                $('#birth_place').val(data.birth_place)
                $('.birth_date').val(data.birth_date_formated)
                $('#tax_number').val(data.phone_number)
                $('#phone_number').val(data.tax_number)
                $('#religion').val(data.religion)
                $('#gender').val(data.gender)
                $('#education').val(data.education)
                $('#mother_name').val(data.mother_name)
                $('#address').val(data.address)
                $('#province_id').val(data.province_id)
                $('#city_id').val(data.city_id)
                $('#district_id').val(data.district_id)
                $('#sub_district_id').val(data.sub_district_id)
                $('#rt').val(data.rt)
                $('#rw').val(data.rw)
                $('#post_code').val(data.post_code)
                $('#is_domicile').val(data.is_domicile)
                $('#current_job').val(data.current_job)
                $('#current_job_address').val(data.current_job_address)
                $('#business_type').val(data.business_type)
                $('#marital_status').val(data.marital_status)
                $('#guarantee_skep_publisher').val(data.skep_publisher)
                $('#guarantee_skep_number').val(data.skep_number)
                $('#guarantee_skep_date').val(data.skep_date_formated)
                $('#guarantee_employee_grade').val(data.employee_grade)
                $('#salary').attr('readonly', false)
                $('#original_paymaster').attr('readonly', false)
                $('#destination_paymaster').attr('readonly', false)
                $('#previous_loan').attr('readonly', false)
                $('#bank_name').attr('readonly', false)
                $('#account_bank_number').attr('readonly', false)
                getCity(data.province_id,'#city_id', data.city_id)
                getDistrict(data.city_id, "#district_id", data.district_id)
                getSubDistrict(data.district_id, "#sub_district_id", data.sub_district_id)

                if(data.is_domicile=='1'){
                    $('#domicileSection').removeClass('d-none');
                    $('#is_domicile').val('0')
                    $('#is_domicile').attr('checked',false)
                }else{
                    $('#domicileSection').removeClass('d-none');
                    $('#domicileSection').addClass('d-none');
                    $('#is_domicile').val('1')
                    $('#is_domicile').attr('checked',true)
                }

                if(data.domicile){
                    $('#domicile_address').val(data.domicile.address)
                    $('#domicile_province_id').val(data.domicile.province_id)
                    $('#domicile_city_id').val(data.domicile.city_id)
                    $('#domicile_district_id').val(data.domicile.district_id)
                    $('#domicile_sub_district_id').val(data.domicile.sub_district_id)
                    $('#domicile_rt').val(data.domicile.rt)
                    $('#domicile_rw').val(data.domicile.rw)
                    $('#domicile_post_code').val(data.domicile.post_code)
                    $('#residential_status').val(data.domicile.residential_status)
                    $('#occupied_at').val(data.domicile.occupied_at)
                    getCity(data.province_id,'#domicile_city_id', data.domicile.city_id)
                    getDistrict(data.city_id, "#domicile_district_id", data.domicile.district_id)
                    getSubDistrict(data.district_id, "#domicile_sub_district_id", data.domicile.sub_district_id)
                }

                if(data.spouse){
                    $('#spouse_name').val(data.spouse.name)
                    $('#spouse_id_number').val(data.spouse.id_number)
                    $('#sp_birth_date').val(moment(data.spouse.birth_date).format('DD-MM-YYYY'))
                    $('#spouse_birth_place').val(data.spouse.birth_place)
                    $('#spouse_job').val(data.spouse.occupation)
                }

                if(data.marital_status=='Kawin'){
                    $('#spouse').removeClass('d-none');
                }else{
                    $('#spouse').removeClass('d-none');
                    $('#spouse').addClass('d-none');
                }

                var today = moment();
                var birthDate = moment(data.birth_date);

                var years = today.diff(birthDate, 'year');
                birthDate.add(years, 'years');
                var months = today.diff(birthDate, 'months');
                birthDate.add(months, 'months');
                var days = today.diff(birthDate, 'days');

                $('#year').val(years)
                $('#month').val(months)
                $('#day').val(days)
                readOnlyMode(true);
            }
        });
    }

    function getCity(id, elementId = "#city_id", selected=null){
        var token = "{{ csrf_token() }}";
        $.ajax({
            url: "{{ route('master-data.cities') }}",
            method: 'POST',
            data: {
                province_id: id,
                '_token': token
            },
            success: function(response) {
                let selectOption = $(elementId);
                selectOption.empty();
                response.forEach(val => {
                    selectOption.append(`<option value="${val.id}" ${selected==val.id ? 'selected':''}>${val.name}</option>`);
                });
            },
            error: function() {
                alert('Failed to fetch karyawan.');
            }
        });
    }

    function getDistrict(id, elementId="#district_id", selected=null){
        var token = "{{ csrf_token() }}";
        $.ajax({
            url: "{{ route('master-data.districts') }}",
            method: 'POST',
            data: {
                city_id: id,
                '_token': token
            },
            success: function(response) {
                let selectOption = $(elementId);
                selectOption.empty();
                response.forEach(val => {
                    selectOption.append(`<option value="${val.id}" ${selected==val.id ? 'selected':''}>${val.name}</option>`);
                });
            },
            error: function() {
                alert('Failed to fetch karyawan.');
            }
        });
    }

    function getSubDistrict(id, elementId="#sub_district_id", selected=null){
        var token = "{{ csrf_token() }}";
        $.ajax({
            url: "{{ route('master-data.sub-districts') }}",
            method: 'POST',
            data: {
                district_id: id,
                '_token': token
            },
            success: function(response) {
                let selectOption = $(elementId);
                selectOption.empty();
                response.forEach(val => {
                    selectOption.append(`<option value="${val.id}" ${selected==val.id ? 'selected':''}>${val.name}</option>`);
                });
            },
            error: function() {
                alert('Failed to fetch karyawan.');
            }
        });
    }

    function getBranchUnit(id){
        var token = "{{ csrf_token() }}";
        $.ajax({
            url: "{{ route('master-data.dropdown.branch-unit') }}",
            method: 'POST',
            data: {
                service_unit_id: id,
                '_token': token
            },
            success: function(response) {
                let selectOption = $('#branch_unit_id');
                selectOption.empty();
                selectOption.append(`<option value="">Pilih Unit Cabang</option>`);
                response.forEach(val => {
                    selectOption.append(`<option value="${val.id}">${val.name}</option>`);
                });

                $('#branch_unit_id').attr('readonly',false)
            },
            error: function() {
                alert('Failed to fetch karyawan.');
            }
        });
    }
    function getMarketing(id){
        var token = "{{ csrf_token() }}";
        $.ajax({
            url: "{{ route('master-data.dropdown.marketing') }}",
            method: 'POST',
            data: {
                branch_unit_id: id,
                '_token': token
            },
            success: function(response) {
                let selectOption = $('#marketing_id');
                selectOption.empty();
                response.forEach(val => {
                    selectOption.append(`<option value="${val.id}" data-position="${val.job_title}" data-status="${val.status_pkwt}">${val.name}</option>`);
                });
                $('#marketing_id').attr('readonly',false)
                $('#fronting_agent').attr('readonly',false)
            },
            error: function() {
                alert('Failed to fetch karyawan.');
            }
        });
    }

    function readOnlyMode(readonly = true){
        $('#taspen_id').attr('readonly',readonly).attr('disabled', readonly)
        $('#original_paymaster').attr('readonly',readonly)
        $('#destination_paymaster').attr('readonly',readonly)
        $('#previous_loan').attr('readonly',readonly)
        $('#bank_name').attr('readonly',readonly)
        $('#account_bank_number').attr('readonly',readonly)
        $('#salary').attr('readonly',readonly)
        $('#purpose').attr('readonly',readonly)
        $('#service_unit_id').attr('readonly',readonly).attr('disabled', readonly)
        $('#branch_unit_id').attr('readonly',readonly).attr('disabled', readonly)
        $('#marketing_id').attr('readonly',readonly).attr('disabled', readonly)



        $('.birth_date').attr('disabled', readonly)
        $('#sp_birth_date').attr('disabled', readonly)
        $('#guarantee_skep_date').attr('disabled', readonly)
        $('#product_id').attr('disabled', readonly)
        $('#finance_type_id').attr('disabled', readonly)
        $('#interest_type').attr('disabled', readonly)
        $('#referral_id').attr('disabled', readonly)
    }

    function approveReject(status, description = ''){
        var token = "{{ csrf_token() }}";
        $.ajax({
            url: "{{ route('application.approval.approve-reject',$data->id) }}",
            method: 'POST',
            data: {
                '_token': token,
                'status': status,
                'description':description
            },
            success: function(response) {
                $('#btn-reject').attr('disabled', false);
                $('#btn-pending').attr('disabled', false);
                $('#btn-approve').attr('disabled', false);
                if(status!='pending'){
                    $('#btn-reject').addClass('d-none');
                    $('#btn-pending').addClass('d-none');
                    $('#btn-approve').addClass('d-none');
                }
                Swal.fire("Saved!", "", "success");
            },
            error: function() {
                $('#btn-reject').attr('disabled', false);
                $('#btn-pending').attr('disabled', false);
                $('#btn-approve').attr('disabled', false);
                Swal.fire("Changes are not saved", "", "error");
            }
        });
    }
</script>
@endpush
