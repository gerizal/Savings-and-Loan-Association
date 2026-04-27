@extends('layouts.template')
@section('title','Tambah Bank Pembiayaan')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Bank Pembiayaan</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('master-data.finance.index')}}">Master Data</a></li>
                    <li class="breadcrumb-item active">Tambah Bank Pembiayaan</li>
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
    <div class="col-md-8 col-sm-12 offset-md-2">
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
                            <div class="form-group required">
                                {!! Form::label('Nama', null, ['class' => 'control-label']) !!}
                                {!! Form::text('name', null, ['class' => 'form-control'.($errors->has('name') ? ' is-invalid' : ''), 'id'=>'name','placeholder'=>'Nama']) !!}
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group required">
                                {!! Form::label('Kode Bank', null, ['class' => 'control-label']) !!}
                                {!! Form::text('code', null, ['class' => 'form-control'.($errors->has('code') ? ' is-invalid' : ''), 'id'=>'code','placeholder'=>'Kode Bank/Singkatan']) !!}
                                @error('code')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group required">
                                {!! Form::label('Biaya Administrasi', null, ['class' => 'control-label']) !!}
                                <div class="input-group mb-3">
                                    {!! Form::number('administration_fee', null, ['class' => 'form-control'.($errors->has('administration_fee') ? ' is-invalid' : ''), 'id'=>'administration_fee','placeholder'=>'Biaya Administrasi','step'=>'0.01']) !!}
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                @error('administration_fee')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group required">
                                {!! Form::label('Bunga Bank', null, ['class' => 'control-label']) !!}
                                <div class="input-group mb-3">
                                    {!! Form::number('interest', null, ['class' => 'form-control'.($errors->has('interest') ? ' is-invalid' : ''), 'id'=>'interest','placeholder'=>'Bunga Bank','step'=>'0.01']) !!}
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                @error('interest')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group required">
                                {!! Form::label('Biaya Angsuran', null, ['class' => 'control-label']) !!}
                                <div class="input-group mb-3">
                                    {!! Form::number('installment_fee', null, ['class' => 'form-control'.($errors->has('installment_fee') ? ' is-invalid' : ''), 'id'=>'installment_fee','placeholder'=>'Biaya Admin Bank','step'=>0.01]) !!}
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                @error('installment_fee')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group required">
                                {!! Form::label('Biaya Tata Laksana', null, ['class' => 'control-label']) !!}
                                {!! Form::text('management_fee', null, ['class' => 'currency-mask form-control'.($errors->has('management_fee') ? ' is-invalid' : ''), 'id'=>'management_fee','placeholder'=>'Biaya Tata Laksana']) !!}
                                @error('management_fee')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group required">
                                {!! Form::label('Biaya Materai', null, ['class' => 'control-label']) !!}
                                {!! Form::text('stamp_fee', null, ['class' => 'currency-mask form-control'.($errors->has('stamp_fee') ? ' is-invalid' : ''), 'id'=>'stamp_fee','placeholder'=>'Biaya Materai']) !!}
                                @error('stamp_fee')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group required">
                                {!! Form::label('Alamat', null, ['class' => 'control-label']) !!}
                                {!! Form::textarea('address', null, ['class' => 'form-control'.($errors->has('address') ? ' is-invalid' : ''), 'id'=>'address','placeholder'=>'Alamat','rows'=>4]) !!}
                                @error('address')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required">
                                {!! Form::label('Biaya Buka Rekening', null, ['class' => 'control-label']) !!}
                                {!! Form::text('account_opening_fee', null, ['class' => 'currency-mask form-control'.($errors->has('account_opening_fee') ? ' is-invalid' : ''), 'id'=>'account_opening_fee','placeholder'=>'Biaya Buka Rekening']) !!}
                                @error('account_opening_fee')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group required">
                                {!! Form::label('Biaya Flagging', null, ['class' => 'control-label']) !!}
                                {!! Form::text('flagging_fee', null, ['class' => 'currency-mask form-control'.($errors->has('flagging_fee') ? ' is-invalid' : ''), 'id'=>'flagging_fee','placeholder'=>'Biaya Flagging']) !!}
                                @error('flagging_fee')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group required">
                                {!! Form::label('Biaya Epotpen', null, ['class' => 'control-label']) !!}
                                {!! Form::text('epotpen_fee', null, ['class' => 'currency-mask form-control'.($errors->has('epotpen_fee') ? ' is-invalid' : ''), 'id'=>'epotpen_fee','placeholder'=>'Biaya Epotpen']) !!}
                                @error('epotpen_fee')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group required">
                                {!! Form::label('Biaya Provisi', null, ['class' => 'control-label']) !!}
                                <div class="input-group mb-3">
                                    {!! Form::number('provision_fee', null, ['class' => 'form-control'.($errors->has('provision_fee') ? ' is-invalid' : ''), 'id'=>'provision_fee','placeholder'=>'Biaya Provisi','step'=>'0.01']) !!}
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                @error('provision_fee')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group required">
                                {!! Form::label('Administrasi Koperasi', null, ['class' => 'control-label']) !!}
                                <div class="input-group mb-3">
                                    {!! Form::number('coop_fee', null, ['class' => 'form-control'.($errors->has('coop_fee') ? ' is-invalid' : ''), 'id'=>'coop_fee','placeholder'=>'Administrasi Koperasi','step'=>'0.01']) !!}
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                @error('coop_fee')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group required">
                                {!! Form::label('Pembulatan', null, ['class' => 'control-label']) !!}
                                {!! Form::text('round_off', null, ['class' => 'currency-mask form-control'.($errors->has('round_off') ? ' is-invalid' : ''), 'id'=>'round_off','placeholder'=>'Pembulatan']) !!}
                                @error('round_off')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group required">
                                {!! Form::label('Logo', null, ['class' => 'control-label']) !!}
                                {!! Form::file('logo',  ['class' => "form-control".($errors->has('logo') ? ' is-invalid' : ''), 'id'=>'logo','accept'=>"image/png, image/jpeg",'aria-describedby'=>"slikHelp"]) !!}
                                @if($errors->has('logo'))
                                    <span class="error invalid-feedback">{{ $errors->first('logo') }}</span>
                                @endif
                            </div>
                            <div class="form-group required">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="is_syariah" name="is_syariah" class="form-control {{$errors->has('is_syariah') ? ' is-invalid' : ''}}" {{$data->is_syariah ? 'checked':''}}>
                                    <label for="is_syariah">Syariah</label>
                                </div>
                                @error('is_syariah')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group required">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="is_flash" name="is_flash" class="form-control {{$errors->has('is_flash') ? ' is-invalid' : ''}}" {{$data->is_flash ? 'checked':''}}>
                                    <label for="is_flash">Flash</label>
                                </div>
                                @error('is_flash')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-right">
                    <a href="{{route('master-data.finance.index')}}" class="btn btn-default"><i class="fas fa-times"></i> Batal</a>
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
