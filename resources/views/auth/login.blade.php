
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
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-12 fxt-bg-wrap">
                    
                       
                        <img class="" src="assets/img/artemis.png" alt="">
                        <h1>Hello World</h1>
                
                        <h2>Welcome To GuardMe</h2>
                       
                        <h2>Empowering Security and Concierge Services with Innovative Web and Mobile Solutions.</h2>
                                      
              
            </div> 
            <div class="col-md-8 col-12 fxt-bg-color" style="background-color: #fff;" align="">
                <div class="fxt-content">
                    <div class="fxt-form">
                        <form  method="POST" action="{{ route('login') }}"  autocomplete="off">
                             {{ csrf_field() }}
                            <div class="create-account-login" align="center"><span class="login">Log In</span><span class="create-account">Create Account</span></div>
                            
                            <div class="form-group">
                                <label for="company_name" class="input-label">Company Name<span class="mandatory-field"> *</span></label>
                                <input type="text" id="company_name"  name="company_name" class="form-control" placeholder="Type Company Name" required="required" value="{{ old('company_name') }}" autocomplete="off">
                                 @if ($errors->has('company_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('company_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="user_name" class="input-label">User Name<span class="mandatory-field"> *</span></label>
                                <input type="text" id="user_name"  name="user_name" class="form-control" placeholder="Type User Name" required="required">
                                @if ($errors->has('user_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email" class="input-label">Email Address</label>
                                <input type="text" id="email"  name="email" class="form-control" placeholder="Type Email Address" required="required" value="{{ old('email') }}" autocomplete="off">
                                 @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="input-label">Password<span class="mandatory-field"> *</span></label>
                                <input id="password" type="password" class="form-control" name="password" placeholder="****************" required="required" autocomplete="off">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                
                            </div>

                            <div class="form-group{{ $errors->has('pin_code') ? ' has-error' : '' }}">
                                <label for="pin_code" class="input-label">Pin Code<span class="mandatory-field"> *</span></label>
                                <input id="pin_code" type="pin_code" class="form-control" name="pin_code"
                                 autocomplete="off" value="{{ old('pin_code') }}" required autofocus>

                                @if ($errors->has('pin_code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pin_code') }}</strong>
                                    </span>
                                @endif
                                
                            </div>

                            <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                                <label for="captcha" class="col-md-4 control-label" style="color:#000">Captcha <span class="mandatory-field"> *</span></label>                                
                                <div class="captcha" style="min-height:50px; position:relative">
                                    <span>{!! captcha_img() !!}</span>
                                    <button type="button" style="position:absolute;left:180px; top:10px"
                                     class="btn btn-primary btn-refresh" id="refresh_captcha">Refresh</button>
                                </div>
                                <br/>
                                <input type="text" id="captcha" class="form-control" placeholder="Enter Captcha" name="captcha">
                                @if ($errors->has('captcha'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('captcha') }}</strong>
                                    </span>
                                @endif
                                
                            </div>

                            <div class="form-group" align="center">
                                <button type="submit" class="btn btn-primary" >
                                   Sign In
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="fxt-footer">
                        <p>Or</p>

                        <div class="social-links mt-3" align="center">
                          <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                          <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                          <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                          <a href="#" class="google-plus"><i class="bx bxl-google"></i></a>
                          <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                 <p><a href="/Safety-Security-tips" class="switcher-text2 inline-text">Safety and Security Tips</a></p>
                            </div>

                            <div class="col-md-4 col-12">
                                 <p><a href="/term_of_use" class="switcher-text2 inline-text">Terms of use</a></p>
                            </div>
                            <div class="col-md-2 col-12">
                                 <p><a href="/customer_help" class="switcher-text2 inline-text">Help</a></p>
                            </div>

                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Custom Js -->
<script src="{{asset('js/main.js')}}"></script>
<script type="text/javascript" src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script>
    //after window is loaded completely 
    window.onload = function(){
        //hide the preloader
        document.querySelector(".preloader").style.display = "none";
    }

    $("#refresh_captcha").click(function()
    {
        $.ajax({

          type:'GET',
          url:'/refresh_captcha',
          success:function(data){
            $(".captcha span").html(data.captcha);
          }
        });
    });


</script>

</body>
</html>