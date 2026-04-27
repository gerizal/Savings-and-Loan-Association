@extends('layouts.base-template')
@section('title','Setup Password')

@section('content')
<div class="login-box" style="margin-bottom:120px">
    <div class="login-logo">
        <img  width="90" height="90" src="{{ asset ('/img/logo_kpf.jpg') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    </div>
    <div class="login-logo">
        <a href="/"><b>{{env('APP_NAME')}}</b></a>
    </div>
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
  <!-- /.login-logo -->
  <div class="card-body login-card-body">
    <p class="login-box-msg">Setup Password</p>

    <form id="reset-form" role="form" method="POST" action="{{ route('setup.set.password') }}">
    {{ csrf_field() }}
      <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
        <!-- <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"  placeholder="Email" required autofocus> -->
        <input type="hidden" name="token" value="{{$token}}">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
      </div>
      <div class="form-group input-tool has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
        <input id="password" type="password" class="form-control" name="password" placeholder="New Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif

        <span class="tooltiptext">
          Your password must be at least 8 characters long, contain at least one number and have a mixture of uppercase and lowercase letters.
          <span class='pass-req pass-length'><i class="fa fa-check-circle-o"></i>at least 8 characters</span>
          <span class='pass-req pass-number'><i class="fa fa-check-circle-o"></i>contain a number</span>
          <span class='pass-req pass-upper'><i class="fa fa-check-circle-o"></i>contain an uppercase</span>
          <span class='pass-req pass-lower'><i class="fa fa-check-circle-o"></i>contain a lowercase</span>
        </span>
      </div>
      <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirmation Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
      </div>
      <div class="row">
        <div class="col-xs-6">
            <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Save Password') }}</button>
        </div>
        <!-- /.col -->
        <!-- /.col -->
      </div>
    </form>
  </div>
</div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

@endsection

@push('script')
<script type="text/javascript">
//constructor form
$('#reset-form').validate({
            rules: {
                password : {
                    required: true,
                    passwordPolicy:true,
                },
                password_confirmation:{
                    equalTo:"#password"
                }
            },
            messages : {
                password: {
                    required: "Password can't be blank",
                    number: "Please enter your weight as a numerical value",
                    passwordPolicy:dynamicPasswordError,
                },
                password_confirmation:{
                    equalTo: "Your password doesnt match"
                }
            }

});

$.validator.addMethod("passwordPolicy", function(value) {
    let hasNumber = /^.*(?=.*\d).*$/.test(value)
    let hasUpper = /^.*(?=.*[A-Z]).*$/.test(value)
    let hasLower = /^.*(?=.*[a-z]).*$/.test(value)

    let errorPassword = []
    if(value.length < 8){
        errorPassword.push('at least 8 characters')
    }

    if(!hasNumber){
        errorPassword.push('a number')
    }

    if(!hasUpper){
        errorPassword.push('an uppercase')
    }

    if(!hasLower){
        errorPassword.push('a lowercase')
    }


    if(errorPassword.length<1){

      return true
    }else{
      return false
    }
});

//listener for custom message
function dynamicPasswordError(value,element){
    let error;
    let input_val;
    input_val = $('#password').val()

    let hasNumber = /^.*(?=.*\d).*$/.test(input_val)
    let hasUpper = /^.*(?=.*[A-Z]).*$/.test(input_val)
    let hasLower = /^.*(?=.*[a-z]).*$/.test(input_val)

    let errorPassword = []
    if(input_val.length < 8){
        errorPassword.push('at least 8 characters')
    }

    if(!hasNumber){
        errorPassword.push('a number')
    }

    if(!hasUpper){
        errorPassword.push('an uppercase')
    }

    if(!hasLower){
        errorPassword.push('a lowercase')
    }

    if(errorPassword.length>0){
        let errorPolicy = 'Your password must contain'
        for (let index = 0; index < errorPassword.length; index++) {
            let message = ', ' + errorPassword[index]
            const lastIndex = errorPassword.length -1
            if(index == 0 || errorPassword.length == 1){
                message  = ' ' + errorPassword[index]
            }else if (index == lastIndex){
                message  = ' and ' + errorPassword[index]
            }

            errorPolicy += message
        }

        error = errorPolicy + '.'
        return error
    }
}


//input for password check ui

const input = $('#password')

input.focusin(addClass)
input.focusout(removeClass)

input.on('keyup',function(){
    if (event.keyCode == 32) {
        return false;
    }
    checkStrength($(this).val());
})

input.on('keydown',function(e){
    //prevent space
    if (e.keyCode == 32) {

        return false;
    }
})

function removeClass(){
    $('.tooltiptext').removeClass('tool-visible')
}

function addClass(){
    $('.tooltiptext').addClass('tool-visible')
}

function checkStrength(val){
    console.log(val.length)
    let hasUpper = /^.*(?=.*[A-Z]).*$/.test(val)
    let hasLower = /^.*(?=.*[a-z]).*$/.test(val)
    let hasNumber = /^.*(?=.*\d).*$/.test(val)
    let hasEightChar = val.length >= 8 ? true : false

    if (hasUpper) {
        $('.pass-upper').addClass('active')
    }else if(!hasUpper){
        $('.pass-upper').removeClass('active')
    }

    if (hasLower) {
        $('.pass-lower').addClass('active')
    }else if(!hasLower){
        $('.pass-lower').removeClass('active')
    }

    if (hasNumber) {
        $('.pass-number').addClass('active')
    }else if(!hasNumber){
        $('.pass-number').removeClass('active')
    }

    if (hasEightChar) {
        $('.pass-length').addClass('active')
    }else if(!hasEightChar){
        $('.pass-length').removeClass('active')
    }
}
</script>
@endpush
