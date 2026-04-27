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
    <div class="col-sm-12 col-md-12">
      <!-- jquery validation -->
        <div class="card">
            {{-- <div class="card-header">
                <h3 class="card-title">Quick Example <small>jQuery Validation</small></h3>
            </div> --}}
            <!-- /.card-header -->
            <!-- form start -->
            {!! Form::model($data, $form) !!}
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required @error('first_name') has-danger @enderror">
                                        {!! Form::label('Nama', null, ['class' => 'control-label']) !!}
                                        {!! Form::text('name', null, ['class' => "form-control".($errors->has('name') ? ' is-invalid' : ''), 'id'=>'name','placeholder'=>'Nama Lengkap']) !!}
                                        @if($errors->has('name'))
                                            <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        {!! Form::label('NIK', null, ['class' => 'control-label']) !!}
                                        {!! Form::text('id_number', null, ['class' => "form-control".($errors->has('id_number') ? ' is-invalid' : ''), 'id'=>'id_number','placeholder'=>'NIK']) !!}
                                        @if($errors->has('id_number'))
                                            <span class="error invalid-feedback">{{ $errors->first('id_number') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
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
                                        {!! Form::label('NPWP', null, ['class' => 'control-label']) !!}
                                        {!! Form::text('tax_number', null, ['class' => "form-control".($errors->has('tax_number') ? ' is-invalid' : ''), 'id'=>'tax_number','placeholder'=>'Nomor NPWP']) !!}
                                        @if($errors->has('tax_number'))
                                            <span class="error invalid-feedback">{{ $errors->first('tax_number') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        {!! Form::label('No Telepon/HP', null, ['class' => 'control-label']) !!}
                                        <div class="input-group">
                                            {!! Form::text('phone_number', null, ['class' => "form-control".($errors->has('phone_number') ? ' is-invalid' : ''), 'id'=>'phone_number','placeholder'=>'No Telepon/HP']) !!}
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
                                        {!! Form::select('gender',['Laki - laki'=>'Laki - laki','Perempuan'=>'Perempuan'], null, ['class' => "form-control".($errors->has('gender') ? ' is-invalid' : ''), 'id'=>'gender','placeholder'=>'Laki - laki/Perempuan']) !!}
                                        @if($errors->has('gender'))
                                            <span class="error invalid-feedback">{{ $errors->first('gender') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        {!! Form::label('Pendidikan', null, ['class' => 'control-label']) !!}
                                        {!! Form::select('education',['SD'=>'SD','SMP'=>'SMP','SMA'=>'SMA','S1'=>'S1','S2'=>'S2','S3'=>'S3','DI'=>'DI','DII'=>'DII','DIII'=>'DIII','DIV'=>'DIV','Lainnya'=>'Lainnya'], null, ['class' => "form-control".($errors->has('education') ? ' is-invalid' : ''), 'id'=>'education','placeholder'=>'Pendidikan']) !!}
                                        @if($errors->has('education'))
                                            <span class="error invalid-feedback">{{ $errors->first('education') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group required">
                                        {!! Form::label('Agama', null, ['class' => 'control-label']) !!}
                                        {!! Form::select('religion',['Islam'=>'Islam','Kristen Katholik'=>'Kristen Katholik','Kristen Protestan'=>'Kristen Protestan','Konghucu'=>'Konghucu','Hindu'=>'Hindu','Budha'=>'Budha'], null, ['class' => "form-control".($errors->has('religion') ? ' is-invalid' : ''), 'id'=>'religion','placeholder'=>'Agama']) !!}
                                        @if($errors->has('religion'))
                                            <span class="error invalid-feedback">{{ $errors->first('religion') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        {!! Form::label('Nama Ibu Kandung', null, ['class' => 'control-label']) !!}
                                        {!! Form::text('mother_name', null, ['class' => "form-control".($errors->has('mother_name') ? ' is-invalid' : ''), 'id'=>'mother_name','placeholder'=>'Nama Ibu Kandung']) !!}
                                        @if($errors->has('mother_name'))
                                            <span class="error invalid-feedback">{{ $errors->first('mother_name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group required">
                                        {!! Form::label('Alamat', null, ['class' => 'control-label']) !!}
                                        {!! Form::textarea('address', null, ['class' => "map-input form-control".($errors->has('address') ? ' is-invalid' : ''), 'id'=>'address','placeholder'=>'Alamat','rows'=>'3']) !!}
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
                                        {!! Form::select('province_id',$provinces, null, ['class' => "form-control".($errors->has('province_id') ? ' is-invalid' : ''), 'id'=>'province_id','placeholder'=>'Nama Provinsi']) !!}
                                        @if($errors->has('province_id'))
                                            <span class="error invalid-feedback">{{ $errors->first('province_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        {!! Form::label('Kota/Kabupaten', null, ['class' => 'control-label']) !!}
                                        {!! Form::select('city_id',$cities, null, ['class' => "form-control".($errors->has('city_id') ? ' is-invalid' : ''), 'id'=>'city_id','placeholder'=>'Nama Kota/Kabupaten']) !!}
                                        @if($errors->has('city_id'))
                                            <span class="error invalid-feedback">{{ $errors->first('city_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        {!! Form::label('Kecamatan', null, ['class' => 'control-label']) !!}
                                        {!! Form::select('district_id',$districts, null, ['class' => "form-control".($errors->has('district_id') ? ' is-invalid' : ''), 'id'=>'district_id','placeholder'=>'Nama Kecamatan']) !!}
                                        @if($errors->has('district_id'))
                                            <span class="error invalid-feedback">{{ $errors->first('district_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        {!! Form::label('Desa/Kelurahan', null, ['class' => 'control-label']) !!}
                                        {!! Form::select('sub_district_id',$sub_districts, null, ['class' => "form-control".($errors->has('sub_district_id') ? ' is-invalid' : ''), 'id'=>'sub_district_id','placeholder'=>'Nama Desa/Kelurahan']) !!}
                                        @if($errors->has('sub_district_id'))
                                            <span class="error invalid-feedback">{{ $errors->first('sub_district_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group required">
                                        {!! Form::label('RT', null, ['class' => 'control-label']) !!}
                                        {!! Form::text('rt', null, ['class' => "form-control".($errors->has('rt') ? ' is-invalid' : ''), 'id'=>'rt','placeholder'=>'RT']) !!}
                                        @if($errors->has('rt'))
                                            <span class="error invalid-feedback">{{ $errors->first('rt') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group required">
                                        {!! Form::label('RW', null, ['class' => 'control-label']) !!}
                                        {!! Form::text('rw', null, ['class' => "form-control".($errors->has('rw') ? ' is-invalid' : ''), 'id'=>'rw','placeholder'=>'RW']) !!}
                                        @if($errors->has('rw'))
                                            <span class="error invalid-feedback">{{ $errors->first('rw') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group required">
                                        {!! Form::label('Kode Pos', null, ['class' => 'control-label']) !!}
                                        {!! Form::text('post_code', null, ['class' => "form-control".($errors->has('post_code') ? ' is-invalid' : ''), 'id'=>'post_code','placeholder'=>'Kode Pos']) !!}
                                        @if($errors->has('post_code'))
                                            <span class="error invalid-feedback">{{ $errors->first('post_code') }}</span>
                                        @endif
                                    </div>
                                </div>
                                    <div class="col-md-3">
                                        <div class="form-group required">
                                            {!! Form::label('Geo Location', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('geo_location', null, ['class' => "form-control".($errors->has('geo_location') ? ' is-invalid' : ''), 'id'=>'geo_location','placeholder'=>'Geo Location']) !!}
                                            @if($errors->has('geo_location'))
                                                <span class="error invalid-feedback">{{ $errors->first('geo_location') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                <div class="col-md-12">
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="is_domicile" name="is_domicile" value="{{$data->is_domicile}}" {{$data->is_domicile==1 ?'checked':''}}>
                                            <label for="is_domicile">Alamat Domisili Sesuai Dengan KTP</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 {{$data->is_domicile==1?'d-none':''}}" id="domicileSection">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card-header text-center">
                                                <h5 class="text-center">Alamat Domisili</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group required">
                                                {!! Form::label('Alamat', null, ['class' => 'control-label']) !!}
                                                {!! Form::textarea('domicile_address', null, ['class' => "map-input form-control".($errors->has('domicile_address') ? ' is-invalid' : ''), 'id'=>'domicile_address','placeholder'=>'Alamat','rows'=>'3']) !!}
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
                                                {!! Form::select('domicile_province_id',$provinces, null, ['class' => "form-control".($errors->has('domicile_province_id') ? ' is-invalid' : ''), 'id'=>'domicile_province_id','placeholder'=>'Nama Provinsi']) !!}
                                                @if($errors->has('domicile_province_id'))
                                                    <span class="error invalid-feedback">{{ $errors->first('domicile_province_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group required">
                                                {!! Form::label('Kota/Kabupaten', null, ['class' => 'control-label']) !!}
                                                {!! Form::select('domicile_city_id',$cities, null, ['class' => "form-control".($errors->has('domicile_city_id') ? ' is-invalid' : ''), 'id'=>'domicile_city_id','placeholder'=>'Nama Kota/Kabupaten']) !!}
                                                @if($errors->has('domicile_city_id'))
                                                    <span class="error invalid-feedback">{{ $errors->first('domicile_city_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group required">
                                                {!! Form::label('Kecamatan', null, ['class' => 'control-label']) !!}
                                                {!! Form::select('domicile_district_id',$districts, null, ['class' => "form-control".($errors->has('domicile_district_id') ? ' is-invalid' : ''), 'id'=>'domicile_district_id','placeholder'=>'Nama Kecamatan']) !!}
                                                @if($errors->has('domicile_district_id'))
                                                    <span class="error invalid-feedback">{{ $errors->first('domicile_district_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group required">
                                                {!! Form::label('Desa/Kelurahan', null, ['class' => 'control-label']) !!}
                                                {!! Form::select('domicile_sub_district_id',$sub_districts, null, ['class' => "form-control".($errors->has('domicile_sub_district_id') ? ' is-invalid' : ''), 'id'=>'domicile_sub_district_id','placeholder'=>'Nama Desa/Kelurahan']) !!}
                                                @if($errors->has('domicile_sub_district_id'))
                                                    <span class="error invalid-feedback">{{ $errors->first('domicile_sub_district_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group required">
                                                {!! Form::label('RT', null, ['class' => 'control-label']) !!}
                                                {!! Form::text('domicile_rt', null, ['class' => "form-control".($errors->has('domicile_rt') ? ' is-invalid' : ''), 'id'=>'domicile_rt','placeholder'=>'RT']) !!}
                                                @if($errors->has('domicile_rt'))
                                                    <span class="error invalid-feedback">{{ $errors->first('domicile_rt') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group required">
                                                {!! Form::label('RW', null, ['class' => 'control-label']) !!}
                                                {!! Form::text('domicile_rw', null, ['class' => "form-control".($errors->has('domicile_rw') ? ' is-invalid' : ''), 'id'=>'domicile_rw','placeholder'=>'RW']) !!}
                                                @if($errors->has('domicile_rw'))
                                                    <span class="error invalid-feedback">{{ $errors->first('domicile_rw') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group required">
                                                {!! Form::label('Kode Pos', null, ['class' => 'control-label']) !!}
                                                {!! Form::text('domicile_post_code', null, ['class' => "form-control".($errors->has('domicile_post_code') ? ' is-invalid' : ''), 'id'=>'domicile_post_code','placeholder'=>'Kode Pos']) !!}
                                                @if($errors->has('domicile_post_code'))
                                                    <span class="error invalid-feedback">{{ $errors->first('domicile_post_code') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group required">
                                                {!! Form::label('Geo Location', null, ['class' => 'control-label']) !!}
                                                {!! Form::text('domicile_geo_location', null, ['class' => "form-control".($errors->has('domicile_geo_location') ? ' is-invalid' : ''), 'id'=>'domicile_geo_location','placeholder'=>'Geo Location']) !!}
                                                @if($errors->has('domicile_geo_location'))
                                                    <span class="error invalid-feedback">{{ $errors->first('domicile_geo_location') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        {!! Form::label('Status Rumah', null, ['class' => 'control-label']) !!}
                                        {!! Form::select('residential_status', ['Milik Sendiri'=>'Milik Sendiri','Milik Orang Tua'=>'Milik Orang Tua','Sewa'=>'Sewa','Kos'=>'Kos','Lainnya'=>'Lainnya'],null, ['class' => "form-control".($errors->has('residential_status') ? ' is-invalid' : ''), 'id'=>'residential_status','placeholder'=>'Status Rumah']) !!}
                                        @if($errors->has('residential_status'))
                                            <span class="error invalid-feedback">{{ $errors->first('residential_status') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        {!! Form::label('Menempati Tahun', null, ['class' => 'control-label']) !!}
                                        {!! Form::number('occupied_at',null, ['class' => "form-control".($errors->has('occupied_at') ? ' is-invalid' : ''), 'id'=>'occupied_at','placeholder'=>'Menempati Tahun']) !!}
                                        @if($errors->has('occupied_at'))
                                            <span class="error invalid-feedback">{{ $errors->first('occupied_at') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        {!! Form::label('Pekerjaan Sekarang', null, ['class' => 'control-label']) !!}
                                        {!! Form::text('current_job', null, ['class' => "form-control".($errors->has('current_job') ? ' is-invalid' : ''), 'id'=>'current_job','placeholder'=>'Pekerjaan Sekarang']) !!}
                                        @if($errors->has('current_job'))
                                            <span class="error invalid-feedback">{{ $errors->first('current_job') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        {!! Form::label('Jenis Usaha/Pekerjaan', null, ['class' => 'control-label']) !!}
                                        {!! Form::text('business_type', null, ['class' => "form-control".($errors->has('business_type') ? ' is-invalid' : ''), 'id'=>'business_type','placeholder'=>'Jenis Usaha/Pekerjaan']) !!}
                                        @if($errors->has('business_type'))
                                            <span class="error invalid-feedback">{{ $errors->first('business_type') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group required">
                                        {!! Form::label('Alamat Usaha/Pekerjaan', null, ['class' => 'control-label']) !!}
                                        {!! Form::textarea('current_job_address', null, ['class' => "form-control".($errors->has('current_job_address') ? ' is-invalid' : ''), 'id'=>'current_job_address','placeholder'=>'Alamat Usaha/Pekerjaan','rows'=>3]) !!}
                                        @if($errors->has('current_job_address'))
                                            <span class="error invalid-feedback">{{ $errors->first('current_job_address') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        {!! Form::label('Status Perkawinan', null, ['class' => 'control-label']) !!}
                                        {!! Form::select('marital_status', ['Kawin'=>'Kawin','Belum Kawin'=>'Belum Kawin','Duda'=>'Duda', 'Janda'=>'Janda'],null, ['class' => "form-control".($errors->has('marital_status') ? ' is-invalid' : ''), 'id'=>'marital_status','placeholder'=>'Status Perkawinan']) !!}
                                        @if($errors->has('marital_status'))
                                            <span class="error invalid-feedback">{{ $errors->first('marital_status') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 {{ $data->marital_status=='Kawin' ? '':'d-none'}}" id="spouse">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card-header text-center">
                                                <h5 class="text-center">Data Pasangan</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group required @error('first_name') has-danger @enderror">
                                                {!! Form::label('Nama ', null, ['class' => 'control-label']) !!}
                                                {!! Form::text('spouse_name', null, ['class' => "form-control".($errors->has('spouse_name') ? ' is-invalid' : ''), 'id'=>'spouse_name','placeholder'=>'Nama ']) !!}
                                                @if($errors->has('spouse_name'))
                                                    <span class="error invalid-feedback">{{ $errors->first('spouse_name') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group required @error('first_name') has-danger @enderror">
                                                {!! Form::label('NIK ', null, ['class' => 'control-label']) !!}
                                                {!! Form::text('spouse_id_number', null, ['class' => "form-control".($errors->has('spouse_id_number') ? ' is-invalid' : ''), 'id'=>'spouse_id_number','placeholder'=>'Nama']) !!}
                                                @if($errors->has('spouse_id_number'))
                                                    <span class="error invalid-feedback">{{ $errors->first('spouse_id_number') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group required">
                                                {!! Form::label('Tempat Lahir ', null, ['class' => 'control-label']) !!}
                                                {!! Form::text('spouse_birth_place', null, ['class' => "form-control".($errors->has('spouse_birth_place') ? ' is-invalid' : ''), 'id'=>'spouse_birth_place','placeholder'=>'Tempat Lahir ']) !!}
                                                @if($errors->has('spouse_birth_place'))
                                                    <span class="error invalid-feedback">{{ $errors->first('spouse_birth_place') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group required">
                                                {!! Form::label('Tanggal Lahir', null, ['class' => 'control-label']) !!}
                                                <div class="input-group date" id="spouse_birth_date" data-target-input="nearest">
                                                    {!! Form::text('spouse_birth_date', null, ['class' => 'date-mask form-control datetimepicker-input'.($errors->has('spouse_birth_date') ? ' is-invalid' : ''),'placeholder'=>'Tanggal Lahir','data-target'=>'#spouse_birth_date']) !!}
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
                                                {!! Form::text('spouse_job', null, ['class' => "form-control".($errors->has('spouse_job') ? ' is-invalid' : ''), 'id'=>'spouse_job','placeholder'=>'Pekerjaan']) !!}
                                                @if($errors->has('spouse_job'))
                                                    <span class="error invalid-feedback">{{ $errors->first('spouse_job') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <!-- <div class="col-md-12"> -->
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('NOPEN', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('nopen', null, ['class' => "form-control".($errors->has('nopen') ? ' is-invalid' : ''), 'id'=>'nopen','placeholder'=>'Nopen']) !!}
                                            @if($errors->has('nopen'))
                                                    <span class="error invalid-feedback">{{ $errors->first('nopen') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Nama Skep', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('skep_name', null, ['class' => "form-control".($errors->has('skep_name') ? ' is-invalid' : ''), 'id'=>'skep_name','placeholder'=>'Nama SKEP']) !!}
                                            @if($errors->has('skep_name'))
                                                <span class="error invalid-feedback">{{ $errors->first('skep_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('No. SKEP', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('skep_number', null, ['class' => "form-control".($errors->has('skep_number') ? ' is-invalid' : ''), 'id'=>'skep_number','placeholder'=>'No. Skep']) !!}
                                            @if($errors->has('skep_number'))
                                                <span class="error invalid-feedback">{{ $errors->first('skep_number') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Tanggal SK Pensiun', null, ['class' => 'control-label']) !!}
                                            <div class="input-group date" id="skep_date" data-target-input="nearest">
                                                {!! Form::text('skep_date', null, ['class' => 'date-mask form-control datetimepicker-input'.($errors->has('skep_date') ? ' is-invalid' : ''),'placeholder'=>'Tanggal Lahir','data-target'=>'#skep_date']) !!}
                                                <div class="input-group-append" data-target="#skep_date" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                            @if($errors->has('skep_date'))
                                                <span class="error invalid-feedback">{{ $errors->first('skep_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Kode Jiwa', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('employee_code', null, ['class' => "form-control".($errors->has('employee_code') ? ' is-invalid' : ''), 'id'=>'employee_code','placeholder'=>'Kode Jiwa']) !!}
                                            @if($errors->has('employee_code'))
                                                <span class="error invalid-feedback">{{ $errors->first('employee_code') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Golongan', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('employee_grade', null, ['class' => "form-control".($errors->has('employee_grade') ? ' is-invalid' : ''), 'id'=>'employee_grade','placeholder'=>'Golongan']) !!}
                                            @if($errors->has('employee_grade'))
                                                <span class="error invalid-feedback">{{ $errors->first('employee_grade') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Penerbit SK', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('skep_publisher', null, ['class' => "form-control".($errors->has('skep_publisher') ? ' is-invalid' : ''), 'id'=>'skep_publisher','placeholder'=>'Penerbit SK']) !!}
                                            @if($errors->has('skep_publisher'))
                                                <span class="error invalid-feedback">{{ $errors->first('skep_publisher') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('NIPNRP', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('nipnrp', null, ['class' => "form-control".($errors->has('nipnrp') ? ' is-invalid' : ''), 'id'=>'nipnrp','placeholder'=>'NIPNRP']) !!}
                                            @if($errors->has('nipnrp'))
                                                <span class="error invalid-feedback">{{ $errors->first('nipnrp') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Jenis Pensiun', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('retirement_type', null, ['class' => "form-control".($errors->has('retirement_type') ? ' is-invalid' : ''), 'id'=>'retirement_type','placeholder'=>'Jenis Pensiun']) !!}
                                            @if($errors->has('retirement_type'))
                                                <span class="error invalid-feedback">{{ $errors->first('retirement_type') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group required">
                                            {!! Form::label('Status Peserta', null, ['class' => 'control-label']) !!}
                                            {!! Form::text('participant_status', null, ['class' => "form-control".($errors->has('participant_status') ? ' is-invalid' : ''), 'id'=>'participant_status','placeholder'=>'Status Peserta']) !!}
                                            @if($errors->has('participant_status'))
                                                <span class="error invalid-feedback">{{ $errors->first('participant_status') }}</span>
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
                    <a href="{{route('master-data.taspen.index')}}" class="btn btn-default"><i class="fas fa-times"></i> Batal</a>
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
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script>
    var tempBank=null;
    var tempProduct=null;
    var tempType=null;

    $(function () {
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

        // $("#datetime").on("change.datetimepicker", ({ date, oldDate }) => {
        //     var today = moment();
        //     var birthDate = date;

        //     var years = today.diff(birthDate, 'year');
        //     birthDate.add(years, 'years');
        //     var months = today.diff(birthDate, 'months');
        //     birthDate.add(months, 'months');
        //     var days = today.diff(birthDate, 'days');

        //     $('#year').val(years)
        //     $('#month').val(months)
        //     $('#day').val(days)
        //     // getProduct(years)
        //     $('#salary').attr('readonly', false)
        // });

        $('#province_id').change(function() {
            var id = $(this).val();
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ route('master-data.cities') }}",
                method: 'POST',
                data: {
                    province_id: id,
                    '_token': token
                },
                success: function(response) {
                    let selectOption = $("#city_id");
                    selectOption.empty();
                    response.forEach(val => {
                        selectOption.append(`<option value="${val.id}">${val.name}</option>`);
                    });
                },
                error: function() {
                    alert('Failed to fetch karyawan.');
                }
            });
        });

        $('#city_id').change(function() {
            var id = $(this).val();
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ route('master-data.districts') }}",
                method: 'POST',
                data: {
                    city_id: id,
                    '_token': token
                },
                success: function(response) {
                    let selectOption = $("#district_id");
                    selectOption.empty();
                    response.forEach(val => {
                        selectOption.append(`<option value="${val.id}">${val.name}</option>`);
                    });
                },
                error: function() {
                    alert('Failed to fetch karyawan.');
                }
            });
        });

        $('#district_id').change(function() {
            var id = $(this).val();
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ route('master-data.sub-districts') }}",
                method: 'POST',
                data: {
                    district_id: id,
                    '_token': token
                },
                success: function(response) {
                    let selectOption = $("#sub_district_id");
                    selectOption.empty();
                    response.forEach(val => {
                        selectOption.append(`<option value="${val.id}">${val.name}</option>`);
                    });
                },
                error: function() {
                    alert('Failed to fetch karyawan.');
                }
            });
        });

        $('#domicile_province_id').change(function() {
            var id = $(this).val();
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ route('master-data.cities') }}",
                method: 'POST',
                data: {
                    province_id: id,
                    '_token': token
                },
                success: function(response) {
                    let selectOption = $("#domicile_city_id");
                    selectOption.empty();
                    response.forEach(val => {
                        selectOption.append(`<option value="${val.id}">${val.name}</option>`);
                    });
                },
                error: function() {
                    alert('Failed to fetch karyawan.');
                }
            });
        });

        $('#domicile_city_id').change(function() {
            var id = $(this).val();
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ route('master-data.districts') }}",
                method: 'POST',
                data: {
                    city_id: id,
                    '_token': token
                },
                success: function(response) {
                    let selectOption = $("#domicile_district_id");
                    selectOption.empty();
                    response.forEach(val => {
                        selectOption.append(`<option value="${val.id}">${val.name}</option>`);
                    });
                },
                error: function() {
                    alert('Failed to fetch karyawan.');
                }
            });
        });

        $('#domicile_district_id').change(function() {
            var id = $(this).val();
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ route('master-data.sub-districts') }}",
                method: 'POST',
                data: {
                    district_id: id,
                    '_token': token
                },
                success: function(response) {
                    let selectOption = $("#domicile_sub_district_id");
                    selectOption.empty();
                    response.forEach(val => {
                        selectOption.append(`<option value="${val.id}">${val.name}</option>`);
                    });
                },
                error: function() {
                    alert('Failed to fetch karyawan.');
                }
            });
        });

        $('#is_domicile').click(function(){
            console.log($(this).val());
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
            // const checked = parseInt($(this).val())==1 ? 0:$(this).val()
            // $(this).val(checked)
        })
        $('#marital_status').change(function(){
            console.log($(this).val());
            if($(this).val()=='Kawin'){
                $('#spouse').removeClass('d-none');
            }else{
                $('#spouse').removeClass('d-none');
                $('#spouse').addClass('d-none');
            }
        })
        var date_of_birth = "{{$data->birth_date == ''? '' : $data->birth_date}}"
        if(date_of_birth != ''){
            $('#birth_date').datetimepicker('date', date_of_birth);
        }

        var date_of_skep = "{{$data->skep_date == ''? '' : $data->skep_date}}"
        if(date_of_skep != ''){
            $('#skep_date').datetimepicker('date', date_of_skep);
        }
    })
</script>
@endpush
