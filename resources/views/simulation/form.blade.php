
@extends('layouts.template')
@section('title','Simulasi Pinjaman')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Simulasi Pinjaman</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Simulasi Pinjaman</li>
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
                <div class="card-body" id="simulation">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-default">
                                <div class="card-header text-center">
                                    <h3 class="card-title">Personal Data</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group required @error('first_name') has-danger @enderror">
                                                {!! Form::label('Tanggal Simulasi', null, ['class' => 'control-label']) !!}
                                                {!! Form::text('simulation_date', null, ['class' => "form-control".($errors->has('simulation_date') ? ' is-invalid' : ''), 'id'=>'simulation_date','placeholder'=>'Tanggal Simulasi','readonly'=>true]) !!}
                                                @if($errors->has('simulation_date'))
                                                    <span class="error invalid-feedback">{{ $errors->first('simulation_date') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group required">
                                                {!! Form::label('Nopen', null, ['class' => 'control-label']) !!}
                                                {!! Form::select('nopen',$nopen, null, ['class' => "form-control select2 ".($errors->has('nopen') ? ' is-invalid' : ''), 'id'=>'nopen','placeholder'=>'Nopen']) !!}
                                                @if($errors->has('nopen'))
                                                    <span class="error invalid-feedback">{{ $errors->first('nopen') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group required">
                                                {!! Form::label('Nama Lengkap', null, ['class' => 'control-label']) !!}
                                                {!! Form::text('name', null, ['class' => "form-control".($errors->has('name') ? ' is-invalid' : ''), 'id'=>'name','placeholder'=>'Nama Lengkap']) !!}
                                                @if($errors->has('name'))
                                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group required">
                                                {!! Form::label('Alamat', null, ['class' => 'control-label']) !!}
                                                {!! Form::textarea('address', null, ['class' => "form-control".($errors->has('address') ? ' is-invalid' : ''), 'id'=>'address','placeholder'=>'Alamat','rows'=>'2']) !!}
                                                @if($errors->has('address'))
                                                    <span class="error invalid-feedback">{{ $errors->first('address') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group required">
                                                {!! Form::label('Tanggal Lahir', null, ['class' => 'control-label']) !!}
                                                <div class="input-group date" id="datetime" data-target-input="nearest">
                                                    {!! Form::text('birth_date', null, ['class' => 'date-mask form-control datetimepicker-input'.($errors->has('id_number') ? ' is-invalid' : ''), 'id'=>'birth_date','placeholder'=>'Tanggal Lahir','data-target'=>'#datetime']) !!}
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
                                        <div class="col-md-6">
                                            <div class="form-group required">
                                                {!! Form::label('Gaji Bersih', null, ['class' => 'control-label']) !!}
                                                {!! Form::text('salary', null, ['class' => "currency-mask-2 form-control".($errors->has('salary') ? ' is-invalid' : ''), 'id'=>'salary','placeholder'=>'Gaji Bersih','readonly'=>true]) !!}
                                                @if($errors->has('salary'))
                                                    <span class="error invalid-feedback">{{ $errors->first('salary') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group required">
                                                {!! Form::label('Produk Pembiayaan', null, ['class' => 'control-label']) !!}
                                                {!! Form::select('product_id', $products,null, ['class' => "form-control".($errors->has('product_id') ? ' is-invalid' : ''), 'id'=>'product_id','readonly'=>true]) !!}
                                                @if($errors->has('product_id'))
                                                    <span class="error invalid-feedback">{{ $errors->first('product_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group required">
                                                {!! Form::label('Jenis Pembiayaan', null, ['class' => 'control-label']) !!}
                                                {!! Form::select('finance_type_id', $types, null, ['class' => "form-control".($errors->has('finance_type_id') ? ' is-invalid' : ''), 'id'=>'finance_type_id','placeholder'=>'Jenis Pembiayaan']) !!}
                                                @if($errors->has('finance_type_id'))
                                                    <span class="error invalid-feedback">{{ $errors->first('finance_type_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-default">
                                <div class="card-header">
                                    <h3 class="card-title">Rekomendasi</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
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
                                                {!! Form::text('max_angsuran', null, ['class' => "currency-mask form-control".($errors->has('max_angsuran') ? ' is-invalid' : ''), 'id'=>'max_angsuran','placeholder'=>'Max Angsuran', 'readonly'=>true]) !!}
                                                @if($errors->has('max_angsuran'))
                                                    <span class="error invalid-feedback">{{ $errors->first('max_angsuran') }}</span>
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
                                                {!! Form::label('Angsuran', null, ['class' => 'control-label']) !!}
                                                {!! Form::text('angsuran', null, ['class' => "currency-mask form-control".($errors->has('angsuran') ? ' is-invalid' : ''), 'id'=>'angsuran','placeholder'=>'Angsuran', 'readonly'=>true]) !!}
                                                @if($errors->has('angsuran'))
                                                    <span class="error invalid-feedback">{{ $errors->first('angsuran') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
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
                                                {!! Form::text('administration_fee', null, ['class' => "costs currency-mask form-control".($errors->has('administration_fee') ? ' is-invalid' : ''), 'id'=>'administration_fee','placeholder'=>'0', 'readonly'=>true]) !!}
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
                                                {!! Form::text('management_fee', null, ['class' => "costs currency-mask form-control".($errors->has('management_fee') ? ' is-invalid' : ''), 'id'=>'management_fee','placeholder'=>'0', 'readonly'=>true]) !!}
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
                                                {!! Form::text('insurance_fee', null, ['class' => "costs currency-mask form-control".($errors->has('insurance_fee') ? ' is-invalid' : ''), 'id'=>'insurance_fee','placeholder'=>'0', 'readonly'=>true]) !!}
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
                                                {!! Form::text('account_opening_fee', null, ['class' => "costs currency-mask form-control".($errors->has('account_opening_fee') ? ' is-invalid' : ''), 'id'=>'account_opening_fee','placeholder'=>'0', 'readonly'=>true]) !!}
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
                                                {!! Form::text('stamp_fee', null, ['class' => "costs currency-mask form-control".($errors->has('stamp_fee') ? ' is-invalid' : ''), 'id'=>'stamp_fee','placeholder'=>'0', 'readonly'=>true]) !!}
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
                                                {!! Form::text('information_fee', null, ['class' => "costs currency-mask form-control".($errors->has('information_fee') ? ' is-invalid' : ''), 'id'=>'information_fee','placeholder'=>'0', 'readonly'=>true]) !!}
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
                                                {!! Form::text('mutation_fee', null, ['class' => "costs currency-mask form-control".($errors->has('mutation_fee') ? ' is-invalid' : ''), 'id'=>'mutation_fee','placeholder'=>'0', 'readonly'=>true]) !!}
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
                                                {!! Form::text('provision_fee', null, ['class' => "costs currency-mask form-control".($errors->has('provision_fee') ? ' is-invalid' : ''), 'id'=>'provision_fee','placeholder'=>'0', 'readonly'=>true]) !!}
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
                                                {!! Form::number('blockir_fee', null, ['class' => "text-right form-control".($errors->has('blockir_fee') ? ' is-invalid' : ''), 'id'=>'blockir_fee','placeholder'=>'0', 'readonly'=>true]) !!}
                                                @if($errors->has('blockir_fee'))
                                                        <span class="error invalid-feedback">{{ $errors->first('blockir_fee') }}</span>
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
                                                {!! Form::text('block_installments', null, ['class' => "currency-mask form-control".($errors->has('block_installments') ? ' is-invalid' : ''), 'id'=>'block_installments','placeholder'=>'0', 'readonly'=>true]) !!}
                                                @if($errors->has('block_installments'))
                                                        <span class="error invalid-feedback">{{ $errors->first('block_installments') }}</span>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-right">
                    <button type="button" onclick="checkSimulation()" class="btn btn-default btn-capture"><i class="fas fa-check"></i> Cek Simulasi</button>
                    <button type="button" onclick="resetForm()" class="btn btn-default d-none" id="btn-reset"><i class="fas fa-times"></i> Reset</button>
                    <button type="submit" class="btn btn-success d-none" id="btn-submit"><i class="fas fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-warning d-none" id="btn-edit" onclick="enableForm()"><i class="fas fa-edit"></i> Edit</button>
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

<div class="modal fade bd-example-modal-xl" id="modalCheckSimulasi" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" id="modal-content" style="background: #fff !important;">
            <div class="modal-header" style="background: #fff !important;">
                <img src="{{ asset ('/img/logo_kpf.jpg') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8; height:35px; margin-right:15px;">
                <h5 class="modal-title" id="modalTitle">ANALISA PERHITUNGAN</h5>
                <button type="button" class="close hide-on-capture" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body" style="background: #fff !important;">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table  table-striped table-modal-simulasi" style="width: 100%;">
                            <tr class="bg-green text-bold">
                                <td colspan="2" align="center">Data Pembiayaan</td>
                            </tr>
                            <tr>
                                <td width="50%" align="left">Tanggal Simulasi</td>
                                <td width="50%" align="right" id="mdl_simulation_date">{{$data->simulation_date}}</td>
                            </tr>
                            <tr>
                                <td width="50%" align="left">Nomor Pensiun</td>
                                <td width="50%" align="right" id="mdl_nopen"></td>
                            </tr>
                            <tr>
                                <td width="50%" align="left">Nama Pemohon</td>
                                <td width="50%" align="right" id="mdl_name"></td>
                            </tr>
                            <tr>
                                <td width="50%" align="left">Tanggal Lahir</td>
                                <td width="50%" align="right" id="mdl_birth_date"></td>
                            </tr>
                            <tr>
                                <td width="50%" align="left">Usia Masuk</td>
                                <td width="50%" align="right" id="mdl_age"></td>
                            </tr>
                            <tr class="text-bold">
                                <td width="50%" align="left">Tanggal Lunas</td>
                                <td width="50%" align="right" id="mdl_paid_date"></td>
                            </tr>
                            <tr class="text-bold">
                                <td width="50%" align="left">Usia Lunas</td>
                                <td width="50%" align="right" id="mdl_paid_age"></td>
                            </tr>
                            <tr class="text-bold text-green">
                                <td width="50%" align="left">Gaji Bersih</td>
                                <td width="50%" align="right" id="mdl_salary"></td>
                            </tr>
                            <tr>
                                <td width="50%" align="left">Produk Pembiayaan</td>
                                <td width="50%" align="right" id="mdl_product"></td>
                            </tr>
                            <tr>
                                <td width="50%" align="left">Jenis Pembiayaan</td>
                                <td width="50%" align="right" id="mdl_type"></td>
                            </tr>
                            <tr>
                                <td width="50%" align="left">Tenor</td>
                                <td width="50%" align="right" id="mdl_tenor"></td>
                            </tr>
                            <tr>
                                <td width="50%" align="left">Plafond</td>
                                <td width="50%" align="right" id="mdl_palfond"></td>
                            </tr>
                            <tr>
                                <td width="50%" align="left">Angsuran</td>
                                <td width="50%" align="right" id="mdl_installment"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table  table-striped table-modal-simulasi" style="width: 100%;">
                            <tr class="bg-green text-bold">
                                <td colspan="2" align="center">Rincian Pembiayaan</td>
                            </tr>
                            <tr>
                                <td width="50%" align="left">Biaya Administrasi</td>
                                <td width="50%" align="right" id="mdl_admin_fee"></td>
                            </tr>
                            <tr>
                                <td width="50%" align="left">Biaya Asuransi</td>
                                <td width="50%" align="right" id="mdl_insurance_fee"></td>
                            </tr>
                            <tr>
                                <td width="50%" align="left">Biaya Tatalaksana</td>
                                <td width="50%" align="right" id="mdl_tatalaksana"></td>
                            </tr>
                            <tr>
                                <td width="50%" align="left">Biaya Buka Rekening</td>
                                <td width="50%" align="right" id="mdl_account_opening_fee"></td>
                            </tr>
                            <tr>
                                <td width="50%" align="left">Biaya Materai</td>
                                <td width="50%" align="right" id="mdl_stamp_fee"></td>
                            </tr>
                            <tr>
                                <td width="50%" align="left">Biaya Provisi</td>
                                <td width="50%" align="right" id="mdl_provision_fee"></td>
                            </tr>
                            <tr>
                                <td width="50%" align="left">Biaya Data Informasi</td>
                                <td width="50%" align="right" id="mdl_information_fee"></td>
                            </tr>
                            <tr>
                                <td width="50%" align="left">Biaya Mutasi</td>
                                <td width="50%" align="right" id="mdl_mutation_fee"></td>
                            </tr>
                            <tr>
                                <td width="50%" align="left">Blokir Angsuran</td>
                                <td width="50%" align="right" id="mdl_blockir_fee"></td>
                            </tr>
                            <tr>
                                <td width="50%" align="left">Terima Kotor</td>
                                <td width="50%" align="right" id="mdl_gross_amount"></td>
                            </tr>
                            <tr class="text-bold text-red">
                                <td width="50%" align="left">BPP</td>
                                <td width="50%" align="right" id="mdl_bpp"></td>
                            </tr>
                            <tr>
                                <td width="50%" align="left">Pelunasan</td>
                                <td width="50%" align="right" id="mdl_paid_fee"></td>
                            </tr>
                            <tr class="text-bold">
                                <td width="50%" align="left">Terima Bersih</td>
                                <td width="50%" align="right" id="mdl_net_amount"></td>
                            </tr>
                            <tr>
                                <td width="50%" align="left">Sisa Gaji</td>
                                <td width="50%" align="right" id="mdl_rest_salary"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: #fff !important;">
                <button type="button" onclick="capture('modal-content')" class="btn btn-default btn-capture"><i class="fas fa-camera"></i> Capture</button>
            </div>
        </div>
  </div>
</div>

@endsection

@push('script')
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script>
    console.log('view', 'simulation.form');
    var tempBank=null;
    var tempProduct=null;
    var tempType=null;
    var viewMode = "{{$mode}}"
    var currentData = @json($data);
    var errorsData = @json($errors);
    // console.log('AGE', currentData);

    $('#nopen').change(function () {
        getNopen();
    })
    $(function () {
        $(".select2").select2({
            theme: 'bootstrap4',
            tags: true
        });

        $("#product_id").select2({
            theme: 'bootstrap4',
            tags: true,
            templateResult: formatProductOption
        });

        function formatProductOption(item) {
            var element = $(`<span>${item.text}<span class="float-right text-muted text-primary"></span></span>`)
            if(item.title!=''){
                var element = $(`<span>${item.text}<small class="float-right text-muted text-primary">(${item.title})</small></span>`)
            }
            return element;
        };

        if(viewMode=='show'){
            $('#nopen').attr('readonly', true);
            $('#name').attr('readonly', true);
            $('#address').attr('readonly', true);
            $('#address').attr('birth_date', true);
            $('select').attr('disabled', true)
            $('#btn-reset').addClass('d-none');
            $('#btn-submit').addClass('d-none');
            $('#btn-edit').removeClass('d-none');
            // getNopen();
        }else{
            $('#nopen').attr('readonly', false);
            $('#name').attr('readonly', false);
            $('#address').attr('readonly', false);
            $('#address').attr('birth_date', false);
            $('select').attr('disabled', false)
            $('#btn-reset').removeClass('d-none');
            $('#btn-submit').removeClass('d-none');
            $('#btn-edit').addClass('d-none');
        }

        if(viewMode=='edit' || viewMode=='show'){
            getNopen();
            getProduct(currentData.year)
        }

        $('#datetime').datetimepicker({
            format: 'DD-MM-YYYY'
        })

        $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })

        getType()

        $("#datetime").on("change.datetimepicker", ({ date }) => {
            if(date) {
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
                getProduct(years)
            }
        });

        $("#product_id").on('change', function(){
            var element = $(this).find('option:selected')
            if(element && element.attr("data")) {
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
                $("#max_angsuran").val(maxInstallment)
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
            } else {
                $("#max_angsuran").val('')
                $("#max_tenor").val('')
                $("#account_opening_fee").val(0)
                $("#stamp_fee").val(0)
                $("#tenor").attr({
                    "max" : '',
                    "min" : '',
                    'readonly': true
                });
                $('#information_fee').val(0)
            }
        });

        $("#tenor").on('keyup', function(e){
            var interest = tempProduct.interest/100
            var monthlyInterest = interest/12
            var maxPlafon = PV(monthlyInterest,$("#tenor").val(), parseInt($("#max_angsuran").val()))
            $("#max_plafon").val(maxPlafon)
            $("#plafon").val(null)
            $("#plafon").attr({
                "max" : maxPlafon,
                "min" : 1,
                'readonly': false
            });
        });

        $("#tenor").on('change', function(e){
            var interest = tempProduct.interest/100
            var monthlyInterest = interest/12
            var maxPlafon = PV(monthlyInterest,$("#tenor").val(), parseInt($("#max_angsuran").val()))
            $("#max_plafon").val(maxPlafon)
            $("#plafon").val(null)
            $("#plafon").attr({
                "max" : maxPlafon,
                "min" : 1,
                'readonly': false
            });
        });

        $("#finance_type_id").on('change', function(){
            var element = $(this).find('option:selected')
            var data = element.attr("data")
            if(data) {
                data = JSON.parse(data)
                tempType = data
                $('#mutation_fee').val(data.mutation_fee)
            }
        });

        $("#plafon").on('keyup', function(e){
            var interest = tempProduct.interest/100
            var monthlyInterest = interest/12

            var plafon = parseInt(e.target.value)
            var tenor = $('#tenor').val()
            var angsuran = pmt(monthlyInterest, tenor, plafon, tempBank.round_off)
            var restSalary = parseInt($("#salary").val()) - angsuran
            $("#angsuran").val(angsuran)
            $("#rest_salary").val(restSalary)
            calculateResults()
        });

        $("#blockir_fee").on('keyup', function(e){
            var installment = $("#angsuran").val() || 0
            var blockInstallemt = parseInt(e.target.value) * parseInt(installment);
            $('#block_installments').val(blockInstallemt)
            calculateResults()
        });

        $("#blockir_fee").on('change', function(e){
            var installment = $("#angsuran").val() || 0
            var blockInstallemt = parseInt(e.target.value) * parseInt(installment);
            $('#block_installments').val(blockInstallemt)
            calculateResults()
        });

        $("#repayment_fee").on('keyup', function(e){
            calculateResults()
        });

        $("#bpp_fee").on('keyup', function(e){
            calculateResults()
        });

        $("#birth_date").on('keyup', function(e){
            if(e.target.value.length>=8){
                var today = moment();
                var birthDate = moment($("#birth_date").val(), 'DD-MM-YYYY');

                var years = today.diff(birthDate, 'year');
                birthDate.add(years, 'years');
                var months = today.diff(birthDate, 'months');
                birthDate.add(months, 'months');
                var days = today.diff(birthDate, 'days');

                $('#year').val(years)
                $('#month').val(months)
                $('#day').val(days)
                $('#salary').attr('readonly', false)
                getProduct(years)
            }
        });

        $(".costs").on('keyup', function(e){
            var plafon = $('#plafon').val() || 0;
            plafon = parseInt(plafon)
            var administration_fee = $('#administration_fee').val() || 0;
            var management_fee = $('#management_fee').val() || 0;
            var insurance_fee = $('#insurance_fee').val() || 0;
            var account_opening_fee = $('#account_opening_fee').val() || 0;
            var stamp_fee = $('#stamp_fee').val() || 0;
            var by_info = $('#information_fee').val() || 0;
            var mutation_fee = $('#mutation_fee').val() || 0;
            var provision_fee = $('#provision_fee').val() || 0;
            var block_installment = $('#block_installments').val() || 0;
            var deduction = parseInt(administration_fee)+parseInt(management_fee)+parseInt(insurance_fee)+parseInt(account_opening_fee)+parseInt(stamp_fee)+parseInt(by_info)+parseInt(mutation_fee)+parseInt(provision_fee)+parseInt(block_installment)
            var gross_amount = plafon-deduction
            var repayment_fee = $('#repayment_fee').val() || 0
            var bpp_fee = $('#bpp_fee').val() || 0
            var net_amount = plafon-deduction-parseInt(repayment_fee)-parseInt(bpp_fee)
            $('#gross_amount').val(gross_amount)
            $('#net_amount').val(net_amount)
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
                    let selected = false;
                    if(currentData.product_id==value.id){
                        selected=true;
                    }
                    $('#product_id').append($('<option>').text(value.name).attr('title',value.bank.name).attr('selected',selected).attr('value', value.id).attr('maxtenor', value.max_tenor).attr('maxplafon', value.max_plafon).attr('data',JSON.stringify(value)));
                });

                $('#product_id').trigger('change');

                if(viewMode!='show' && data.length==0)
                {
                    Swal.fire({
                    title: 'Error!',
                    text: 'Tidak ada produk yang sesuai dengan umur anda',
                    icon: 'error',
                    confirmButtonText: 'Cool'
                    })
                }
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
                // console.log('Response', data);
                $('#finance_type_id').empty();
                $('#finance_type_id').append($('<option>').text('Please Select').attr('value', '').attr('maxtenor', ''));
                $.each(data, function(key, value) {
                    let selected = false;
                    if(currentData.finance_type_id==value.id){
                        selected=true;
                    }
                    $('#finance_type_id').append($('<option>').text(value.name).attr('selected',selected).attr('value', value.id).attr('data',JSON.stringify(value)));
                });
                $('#finance_type_id').trigger('change');
            }
        });
    }

    function resetForm(){
        $('form').trigger("reset")
        $('form select').trigger("change")
        enableForm()
        tempBank=null;
        tempProduct=null;
        tempType=null;
    }

    function enableForm(){
        $('#nopen').attr('readonly', false);
        $('#name').attr('readonly', false);
        $('#address').attr('readonly', false);
        $('#address').attr('readonly', false);
        $('select').attr('disabled', false)
        $('#blockir_fee').attr('readonly', false);
        $('#bpp_fee').attr('readonly', false);
        $('#repayment_fee').attr('readonly', false);
        $('#btn-reset').removeClass('d-none');
        $('#btn-submit').removeClass('d-none');
        $('#btn-edit').addClass('d-none');
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
        var block_installment = $('#block_installments').val() || 0;
        var deduction = parseInt(administration_fee)+parseInt(management_fee)+parseInt(insurance_fee)+parseInt(account_opening_fee)+parseInt(stamp_fee)+parseInt(by_info)+parseInt(mutation_fee)+parseInt(provision_fee)+parseInt(block_installment)
        var gross_amount = plafon-deduction
        var repayment_fee = $('#repayment_fee').val() || 0
        var bpp_fee = $('#bpp_fee').val() || 0
        var net_amount = plafon-deduction-parseInt(repayment_fee)-parseInt(bpp_fee)
        $('#gross_amount').val(gross_amount)
        $('#net_amount').val(net_amount)
        $("#blockir_fee").attr('readonly', false)
        $("#bpp_fee").attr('readonly', false)
        $("#repayment_fee").attr('readonly', false)
        $(".costs").attr('readonly',false).attr('disabled', false)

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

    function checkSimulation() {
        let start_age = `${$("#year").val()||0} Tahun ${$("#month").val()||0} Bulan ${$("#day").val()||0} Hari`
        var birthDate = '';
        var simulationDate = '';
        if($("#birth_date").val()){
            birthDate = moment($("#birth_date").val(),'DDMMYYYY')
            birthDateString = moment($("#birth_date").val(),'DDMMYYYY').format('DD-MM-YYYY')
        }

        if($("#simulation_date").val()){
            simulationDate = moment($("#simulation_date").val(),'DD-MM-YYYY').format('DD-MM-YYYY')
        }
        let paid_date = ''
        let end_paid_date = ''
        var years = 0;
        var months = 0;
        var days = 0;
        if($("#tenor").val()){
            paid_date = moment().add($("#tenor").val(), 'months')
            end_paid_date = moment().add($("#tenor").val(), 'months').format('DD-MM-YYYY')
            years = paid_date.diff(birthDate, 'year');
            birthDate.add(years, 'years');
            months = paid_date.diff(birthDate, 'months');
            birthDate.add(months, 'months');
            days = paid_date.diff(birthDate, 'days');
        }
        let finish_age = `${years} Tahun ${months} Bulan ${days} Hari`
        $("#mdl_simulation_date").html(simulationDate)
        $("#mdl_nopen").html($("#nopen").val())
        $("#mdl_name").html($("#name").val())
        $("#mdl_birth_date").html(birthDateString)
        $("#mdl_age").html(start_age)
        $("#mdl_paid_date").html(end_paid_date)
        $("#mdl_paid_age").html(finish_age)
        $("#mdl_salary").html(formatIDR($("#salary").val()))
        $("#mdl_product").html($('#product_id option:selected').text())
        $("#mdl_type").html($('#finance_type_id option:selected').text())
        $("#mdl_tenor").html($("#tenor").val()||'0')
        $("#mdl_palfond").html(formatIDR($("#plafon").val()))
        $("#mdl_installment").html(formatIDR($("#angsuran").val()))
        $("#mdl_admin_fee").html(formatIDR($("#administration_fee").val()))
        $("#mdl_insurance_fee").html(formatIDR($("#insurance_fee").val()))
        $("#mdl_tatalaksana").html(formatIDR($("#management_fee").val()))
        $("#mdl_account_opening_fee").html(formatIDR($("#account_opening_fee").val()))
        $("#mdl_stamp_fee").html(formatIDR($("#stamp_fee").val()))
        $("#mdl_provision_fee").html(formatIDR($("#provision_fee").val()))
        $("#mdl_information_fee").html(formatIDR($("#information_fee").val()))
        $("#mdl_mutation_fee").html(formatIDR($("#mutation_fee").val()))
        $("#mdl_blockir_fee").html(formatIDR($("#block_installments").val()))
        $("#mdl_gross_amount").html(formatIDR($("#gross_amount").val()))
        $("#mdl_bpp").html(formatIDR($("#bpp_fee").val()))
        $("#mdl_paid_fee").html(formatIDR($("#repayment_fee").val()))
        $("#mdl_net_amount").html(formatIDR($("#net_amount").val()))
        $("#mdl_rest_salary").html(formatIDR($("#rest_salary").val()))
        $('#modalCheckSimulasi').modal('show')
    }

    function capture(nodeId) {
        $('.btn-capture').addClass('invisible')
        $('.hide-on-capture').addClass('invisible')
        const captureElement = document.querySelector('#'+nodeId)
        html2canvas(captureElement)
        .then(canvas => {
            canvas.style.display = 'none'
            document.body.appendChild(canvas)
            return canvas
        })
        .then(canvas => {
            const image = canvas.toDataURL('image/png').replace('image/png', 'image/octet-stream')
            const a = document.createElement('a')
            a.setAttribute('download', 'form-simulasi.png')
            a.setAttribute('href', image)
            a.click()
            canvas.remove()
        })
        $('.btn-capture').removeClass('invisible')
        $('.hide-on-capture').removeClass('invisible')
    }

    function getNopen(){
        // $('#name').val(null)
        // $('#address').val(null)
        // $('#birth_date').val(null)
        $.ajax({
            url: "{{ route('master-data.taspen.detail') }}",
            data : {
                'nopen' : $('#nopen').val(),
                'byNopen':true,
                _token: "{{ csrf_token() }}"
            },
            type: 'post',
            success: function(res) {
                if(res.data){
                    $('#name').val(res.data.name)
                    $('#address').val(res.data.address)
                    $('#birth_date').val(res.data.birth_date_formated)
                    var today = moment();
                    var birthDate = moment(res.data.birth_date);

                    var years = today.diff(birthDate, 'year');
                    birthDate.add(years, 'years');
                    var months = today.diff(birthDate, 'months');
                    birthDate.add(months, 'months');
                    var days = today.diff(birthDate, 'days');

                    $('#year').val(years)
                    $('#month').val(months)
                    $('#day').val(days)
                    $('#salary').attr('readonly', false)
                    getProduct(years)
                    calculateResults()
                }
            }
        })

    }

    function formatIDR(number){
        if(number){
            return new Intl.NumberFormat("id-ID", {style: "currency",currency: "IDR"}).format(parseInt(number));
        }else{
            return '0';
        }
    }
</script>
@endpush
