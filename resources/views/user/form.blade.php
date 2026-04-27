@extends('layouts.template')
@section('title','Tambah Referral')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Pengguna</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('user.index')}}">Pengaturan Pengguna</a></li>
                    <li class="breadcrumb-item active">{{$create ? 'Tambah':'Edit'}}</li>
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
            {!! Form::hidden('role_name', null, ['class' => "form-control", 'id'=>'role_name']) !!}
                <div class="card-body">
                    <div class="box-body">
                        <div class="form-group required">
                            <div class="col-md-12">
                                {!! Form::label('Nama Lengkap', null, ['class' => 'control-label']) !!}
                                {!! Form::text('name', null, ['class' => 'form-control'.($errors->has('name') ? ' is-invalid' : ''), 'id'=>'name','placeholder'=>'Nama']) !!}
                                @if($errors->has('name'))
                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group required">
                            <div class="col-md-12">
                                {!! Form::label('Email', null, ['class' => 'control-label']) !!}
                                {!! Form::email('email', null, ['class' => 'form-control'.($errors->has('email') ? ' is-invalid' : ''), 'id'=>'email','placeholder'=>'Email']) !!}
                                @if($errors->has('email'))
                                    <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group required @error('role_id') has-danger @enderror">
                            <div class="col-md-12">
                                {!! Form::label('Role', null, ['class' => 'control-label']) !!}
                                {!! Form::select('role_id', $roles, null, ['class' => "form-control".($errors->has('role_id') ? ' is-invalid' : ''), 'id'=>'role_id','placeholder'=>'Role']) !!}
                                @if($errors->has('role_id'))
                                    <span class="error invalid-feedback">{{ $errors->first('role_id') }}</span>
                                @endif
                            </div>
                        </div>
                        <div id="bank-box" class="form-group required {{$data->bank_id == null || $data->bank_id == '' ? 'd-none':''}}">
                            <div class="col-md-12">
                                {!! Form::label('Bank', null, ['class' => 'control-label']) !!}
                                {!! Form::select('bank_id', $banks, null, ['class' => "form-control".($errors->has('bank_id') ? ' is-invalid' : ''), 'id'=>'bank_id']) !!}
                                @if($errors->has('bank_id'))
                                    <span class="error invalid-feedback">{{ $errors->first('bank_id') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="box-footer text-right">
                        <a href="{{route('user.index')}}" class="btn btn-default"><i class="fas fa-times"></i> Batal</a>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </div>
                <!-- /.card-body -->
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
        $('#role_id').on('change', function(e){
            var selectedText = $(this).find("option:selected").text();
            $('#role_name').val(selectedText);
            selectedText = selectedText.toLowerCase()
            $('#bank_id').val('');
            if(selectedText=='approval' || selectedText=='bank'){
                $('#bank-box').removeClass('d-none');
            }else{
                $('#bank-box').removeClass('d-none').addClass('d-none');
            }
        })
    })
</script>
@endpush
