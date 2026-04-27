@extends('layouts.template')
@section('title','Tambah Produk Pembiayaan')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Produk Pembiayaan</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('master-data.finance.index')}}">Master Data</a></li>
                    <li class="breadcrumb-item active">Tambah Produk Pembiayaan</li>
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
    <div class="col-md-8 col-sm-12 col-xs-12 offset-md-2">
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
                                {!! Form::label('name', null, ['class' => 'control-label']) !!}
                                {!! Form::text('name', null, ['class' => 'form-control'.($errors->has('name') ? ' is-invalid' : ''), 'id'=>'name','placeholder'=>'Nama']) !!}
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group required">
                                {!! Form::label('Biaya Asuransi', null, ['class' => 'control-label']) !!}
                                <div class="input-group mb-3">
                                    {!! Form::number('insurance_fee', null, ['class' => 'form-control'.($errors->has('insurance_fee') ? ' is-invalid' : ''), 'id'=>'insurance_fee','placeholder'=>'Biaya Asuransi','step'=>'0.01']) !!}
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                @error('insurance_fee')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group required">
                                {!! Form::label('Bunga', null, ['class' => 'control-label']) !!}
                                <div class="input-group mb-3">
                                    {!! Form::number('interest', null, ['class' => 'form-control'.($errors->has('interest') ? ' is-invalid' : ''), 'id'=>'interest','placeholder'=>'Bunga','step'=>'0.01']) !!}
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                @error('interest')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group required">
                                {!! Form::label('Minimal Usia', null, ['class' => 'control-label']) !!}
                                <div class="input-group mb-3">
                                    {!! Form::number('min_age', null, ['class' => 'form-control'.($errors->has('min_age') ? ' is-invalid' : ''), 'id'=>'min_age','placeholder'=>'Minimal Usia','step'=>'0.01']) !!}
                                    <div class="input-group-append">
                                        <span class="input-group-text">Tahun.Bulan</span>
                                    </div>
                                </div>
                                @error('min_age')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group required">
                                {!! Form::label('Maksimal Usia', null, ['class' => 'control-label']) !!}
                                <div class="input-group mb-3">
                                    {!! Form::number('max_age', null, ['class' => 'form-control'.($errors->has('max_age') ? ' is-invalid' : ''), 'id'=>'max_age','placeholder'=>'Maksimal Usia','step'=>'0.01']) !!}
                                    <div class="input-group-append">
                                        <span class="input-group-text">Tahun.Bulan</span>
                                    </div>
                                </div>
                                @error('max_age')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group required">
                                {!! Form::label('Maksimal Usia Lunas', null, ['class' => 'control-label']) !!}
                                <div class="input-group mb-3">
                                    {!! Form::number('max_paid_age', null, ['class' => 'form-control'.($errors->has('max_paid_age') ? ' is-invalid' : ''), 'id'=>'max_paid_age','placeholder'=>'Maksimal Usia Lunas','step'=>'0.01']) !!}
                                    <div class="input-group-append">
                                        <span class="input-group-text">Tahun.Bulan</span>
                                    </div>
                                </div>
                                @error('max_paid_age')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required">
                                {!! Form::label('Maksimal Tenor', null, ['class' => 'control-label']) !!}
                                {!! Form::number('max_tenor', null, ['class' => 'form-control'.($errors->has('max_tenor') ? ' is-invalid' : ''), 'id'=>'max_tenor','placeholder'=>'Maksimal Tenor']) !!}
                                @error('max_tenor')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group required">
                                {!! Form::label('Maksimal Plafon', null, ['class' => 'control-label']) !!}
                                {!! Form::text('max_plafon', null, ['class' => 'currency-mask form-control'.($errors->has('max_plafon') ? ' is-invalid' : ''), 'id'=>'max_plafon','placeholder'=>'Maksimal Plafon']) !!}
                                @error('max_plafon')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group required">
                                {!! Form::label('Bank Pembiayaan', null, ['class' => 'control-label']) !!}
                                {!! Form::select('bank_id', $bank,null, ['class' => 'form-control'.($errors->has('bank_id') ? ' is-invalid' : ''), 'id'=>'bank_id','placeholder'=>'Bank Pembiayaan']) !!}
                                @error('bank_id')
                                    <span class="invalid-feedback">{{ $message }}<</span>
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
