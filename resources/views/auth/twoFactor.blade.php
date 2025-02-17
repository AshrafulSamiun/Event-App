
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="msapplication-tap-highlight" content="no">
    <title>ARTEMIS SECURITIES</title>
    <link href="assets/img/armitis_security.png" rel="icon">

    <!------------CSS-------------->
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
    <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
</head>

<body>

<div id="preloader" class="preloader">
    <div class='inner'>
        <div class='line1'></div>
        <div class='line2'></div>
        <div class='line3'></div>
    </div>
</div>

<section class="fxt-template-animation fxt-template-layout4">
    <div class="container fxt-template-animation fxt-template-layout4">
        <div class="row justify-content-center fxt-bg-wra">
            <div class="col-md-4 col-12 fxt-bg-wrap">                       
                <img class="" src="assets/img/artemis.png" alt="">
        
                <h2>Welcome To GuardMe</h2>
                       
                <h2> Empowering Security and Concierge Services with Innovative Web and Mobile Solutions.</h2>
               
            </div> 
            <div class="col-md-8  ">
            <div class="card-group" >
                <div class="card p-4">
                    <div class="card-body" style="background:#fff; padding:70px 0; text-align: center;" align="center">
                        @if(session()->has('message'))
                            <p class="alert alert-info">
                                {{ session()->get('message') }}
                            </p>
                        @endif
                        <form method="POST" action="{{ route('verify.store') }}">
                            {{ csrf_field() }}
                            <h4 style="font-family: Inter;
                                font-size: 22px;
                                font-weight: 700;
                                line-height: 26.63px;
                                text-align: center;
                                ">
                                Verification Code
                            </h4>
                            
              
                            <p style="font-family: Poppins;font-size: 17px;font-weight: 500;line-height: 27px;text-align: center;">
                               We have sent the verification code to your email address.This code will expire within 10 minutes.<br/>
                                
                            </p>
                            <div class="input-group mb-3 text-center">
                               
                                <input name="two_factor_code" id="two_factor_code" type="hidden" class="form-control{{ $errors->has('two_factor_code') ? ' is-invalid' : '' }}"
                                 required autofocus placeholder="Two Factor Code">
                                @if($errors->has('two_factor_code'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('two_factor_code') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group d-flex text-center" id="twoFactordiv" align="center"
                                style=" margin-left: 100px;">
                                <div class="col-md-1 ">
                                    <input 
                                        type="text" 
                                        id="singleFactor1"  
                                        class=" tofactorinput" 
                                        maxlength="1" 
                                        onkeyup="populateTwoFactorCode(1)" 
                                        name="singletext[]"  
                                        required>
                                </div>
                                <div class="col-md-2 ">
                                    <input  
                                        type="text" 
                                        id="singleFactor2" 
                                        class=" tofactorinput" 
                                        maxlength="1" 
                                        onkeyup="populateTwoFactorCode(2)" 
                                        name="singletext[]" 
                                        style="margin-left: 25px;" 
                                        required>
                                </div> 
                                <div class="col-md-1 "> 
                                    <input 
                                        type="text" 
                                        id="singleFactor3" 
                                        class=" tofactorinput" 
                                        maxlength="1" 
                                        onkeyup="populateTwoFactorCode(3)" 
                                        name="singletext[]" 
                                        required>
                                </div> 
                                <div class="col-md-2 "> 
                                    <input 
                                        type="text" 
                                        id="singleFactor4" 
                                        class=" tofactorinput" 
                                        maxlength="1" 
                                        onkeyup="populateTwoFactorCode(4)" 
                                        name="singletext[]" 
                                        style="margin-left: 25px;" 
                                        required>
                                </div>
                                <div class="col-md-1 ">
                                    <input 
                                        type="text" 
                                        id="singleFactor5" 
                                        class=" tofactorinput" 
                                        maxlength="1" 
                                        onkeyup="populateTwoFactorCode(5)" 
                                        name="singletext[]" 
                                        required>
                                
                                </div>
                                <div class="col-md-2 ">
                                    <input 
                                        type="text" 
                                        id="singleFactor6" 
                                        class=" tofactorinput" 
                                        maxlength="1" 
                                        onkeyup="populateTwoFactorCode(6)" 
                                        name="singletext[]" 
                                        style="margin-left: 25px;" 
                                        required>
                                </div>
                            </div>
                            <div class="row"  style="margin-top:20px" align="center">
                                <div class="col-md-6 " style="margin-top:20px; margin-left: 150px;">
                                    <p class="text-muted">
                                         <a href="{{ route('verify.resend') }}"><strong>Resend Code</strong></a>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3" style="margin-left: 150px;">
                                    <button type="submit" class="btn btn-primary">
                                        <strong>Verify</strong>
                                    </button>
                                </div>
                                
                            </div>

                           
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</section>

<style type="text/css">
    
    .tofactorinput {

        font-family: Inter;
        font-size: 24px;
        font-weight: 700;
        line-height: 29.05px;
        text-align: center;
        width:50px; 
        height:50px;
        border-radius: 10px;
        border: 1.6px solid #DDDDDD;

    }
    .tofactorinput:hover {
        border: 1.8px solid;

        border-image-source: linear-gradient(180deg, #FF8D4D 0%, #FF4D97 100%),
        linear-gradient(0deg, #2D7BFC, #2D7BFC);



    }
</style>
<!-- Custom Js -->
<script src="{{asset('js/main.js')}}"></script>
<script type="text/javascript" src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
 <script>

    window.onload = function(){
        //hide the preloader
        document.querySelector(".preloader").style.display = "none";
    }
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

</body>
</html>