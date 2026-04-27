@extends('layouts.base-template')
@section('title','Reset Password')

@section('content')
<div class="login-box" style="margin-bottom:120px">
<div class="login-logo" >
        <img width="90" height="90" src="{{ asset ('/img/logo_kpf.jpg') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    </div>
    <div class="login-logo">
        <a href="/"><b>{{env('APP_NAME')}}</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
        <div class="card-body login-card-body">
            <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
            <form action="{{route('password.submit.email.reset')}}" method="post">
                @csrf
                <div class="input-group mb-3 {{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control" placeholder="Email" name="email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Request new password</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <p class="mt-3 mb-1">
                <a href="{{route('login')}}">Login</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
@endsection

