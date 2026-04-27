@extends('layouts.template')
@section('title','Tambah Jenis Pembiayaan')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Jenis Pembiayaan</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('master-data.finance.index')}}">Master Data</a></li>
                    <li class="breadcrumb-item active">Tambah Jenis Pembiayaan</li>
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
                        {!! Form::label('Nama', null, ['class' => 'control-label']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control'.($errors->has('name') ? ' is-invalid' : ''), 'id'=>'name','placeholder'=>'Nama']) !!}
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group required">
                        {!! Form::label('Biaya Mutasi', null, ['class' => 'control-label']) !!}
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            {!! Form::number('mutation_fee', null, ['class' => 'form-control'.($errors->has('mutation_fee') ? ' is-invalid' : ''), 'id'=>'mutation_fee','placeholder'=>'Biaya Mutasi']) !!}
                        </div>
                        @error('mutation_fee')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
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
