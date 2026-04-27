@extends('layouts.template')
@section('title','Tambah Unit Cabang')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Unit Cabang</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('master-data.branch-unit.index')}}">Master Data</a></li>
                    <li class="breadcrumb-item"><a href="{{route('master-data.branch-unit.index')}}">Unit Cabang</a></li>
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
            {!! Form::model($data, $form) !!}
                <div class="card-body">
                    <div class="form-group required">
                        {!! Form::label('Nama Area', null, ['class' => 'control-label']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control'.($errors->has('name') ? ' is-invalid' : ''), 'id'=>'name','placeholder'=>'Nama Area']) !!}
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group required">
                        {!! Form::label('Nomor Kode', null, ['class' => 'control-label']) !!}
                        {!! Form::text('number_code', null, ['class' => 'form-control'.($errors->has('number_code') ? ' is-invalid' : ''), 'id'=>'code','placeholder'=>'Nomor Kode']) !!}
                        @error('number_code')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group required">
                        {!! Form::label('Unit Pelayanan', null, ['class' => 'control-label']) !!}
                        {!! Form::select('unit_pelayanan_id', $service_unit,null, ['class' => 'form-control'.($errors->has('unit_pelayanan_id') ? ' is-invalid' : ''), 'id'=>'unit_pelayanan_id','placeholder'=>'Unit Pelayanan']) !!}
                        @error('unit_pelayanan_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-right">
                    <a href="{{route('master-data.branch-unit.index')}}" class="btn btn-default"><i class="fas fa-times"></i> Batal</a>
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
