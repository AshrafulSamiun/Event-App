@extends('layouts.appExternal')

@section('content')
<div class="container" >
    <div class="row justify-content-center" align="center">
        <div class="col-md-8 col-md-offset-2 ">
            <div class="card-group" >
                <div class="card p-4">
                    <div class="card-body" style="background:#fff; padding:70px 0">
                        @if(session()->has('message'))
                            <p class="alert alert-info">
                                {{ session()->get('message') }}
                            </p>
                        @endif
                        <form method="POST" action="{{ route('verify.store') }}">
                            {{ csrf_field() }}
                            <h1><strong>Two-step Verification Required</strong></h1>
                            <p class="text-muted">
                                <strong style="font-size:20px">We noticed You are signing in with and unknown browser or divice <br/>or recently made changes to your account.                                </strong>
                                </strong>
                            </p>
                            <p class="text-muted">
                                You have received an email which contains two step login code.This code will expire within 10 minutes.<br/>
                                
                            </p>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                </div>
                                <input name="two_factor_code" id="two_factor_code" type="hidden" class="form-control{{ $errors->has('two_factor_code') ? ' is-invalid' : '' }}"
                                 required autofocus placeholder="Two Factor Code">
                                @if($errors->has('two_factor_code'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('two_factor_code') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group" id="twoFactordiv">
                                <div class="col-md-1 col-md-offset-3">
                                    <input type="text" id="singleFactor1"  class="form-control" maxlength="1" onkeyup="populateTwoFactorCode(1)" name="singletext[]" style="width:40px" required>
                                </div>
                                <div class="col-md-1 ">
                                    <input type="text" id="singleFactor2" class="form-control" maxlength="1" onkeyup="populateTwoFactorCode(2)" name="singletext[]" style="width:40px" required>
                                </div> 
                                <div class="col-md-1 "> 
                                    <input type="text" id="singleFactor3" class="form-control" maxlength="1" onkeyup="populateTwoFactorCode(3)" name="singletext[]" style="width:40px" required>
                                </div> 
                                <div class="col-md-1 "> 
                                    <input type="text" id="singleFactor4" class="form-control" maxlength="1" onkeyup="populateTwoFactorCode(4)" name="singletext[]" style="width:40px" required>
                                </div>
                                <div class="col-md-1 ">
                                    <input type="text" id="singleFactor5" class="form-control" maxlength="1" onkeyup="populateTwoFactorCode(5)" name="singletext[]" style="width:40px" required>
                                
                                </div>
                                <div class="col-md-1 ">
                                    <input type="text" id="singleFactor6" class="form-control" maxlength="1" onkeyup="populateTwoFactorCode(6)" name="singletext[]" style="width:40px" required>
                                </div>
                            </div>
                            <div class="row"  style="margin-top:20px">
                                <div class="col-md-6 col-md-offset-3" style="margin-top:20px">
                                    <p class="text-muted">
                                         <a href="{{ route('verify.resend') }}"><strong>Resend Code</strong></a>.
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <strong>Verify</strong>
                                    </button>
                                </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="form-check">
                                      <input  style="width:40px;height:30px;margin-top:30px" class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                      <label class="form-check-label" for="flexCheckChecked">
                                        Trust This browser or device
                                      </label>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
    <script>
        function populateTwoFactorCode(id)
        {
            
            if($("#singleFactor"+id).val())
            {
                id=id+1;
               $("#singleFactor"+id).focus(); 
            }
            
           // $("#singleFactor1").focus();
            var input_value="";
            $("#twoFactordiv input").each(function()
            {
                input_value=input_value+""+$(this).val();
            });
            $("#two_factor_code").val(input_value);
            //alert(input_value)
        }
    </script>
</div>

@endsection