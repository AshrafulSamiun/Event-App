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
                        <h1>ARTEMIS SECURITY & CONCIERGE TECHNOLOGY LTD.</h1>
                
                        <h2>Welcome To Our Service</h2>
                        <p> Front Desk to Frontline</p>
                        <p>Elevating Security and Service for Security Guard and Concierge Companies</p>
                        <h2>Create Your Account </h2>
                        <p> To keep connected with us please  login with your personal info</p>
                        <button class="auth-button" type="button">SIGN IN </button>
                        <p> Or Sign In with this verification platform</p>
                    
                    <div class="social-links mt-3" align="center">
                      <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                      <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                      <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                      <a href="#" class="google-plus"><i class="bx bxl-google"></i></a>
                      <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                    </div>
              
            </div>
            <div class="col-md-8 col-12 fxt-bg-color" style="background-color: #fff;">
                <div class="fxt-content">
                    <div class="fxt-form">
                        <form class="form-horizontal" method="POST" action="{{ route('register') }}" style="margin-top:30px;">
                             {{ csrf_field() }}
                            <div class="login-create-account"><span class="login">Log In</span><span class="create-account">Create Account</span></div>
                            <div class="form-group">
                                <label for="email" class="input-label">Company Name</label>
                                <input type="text" id="email"  name="email" class="form-control" placeholder="Type Company Name" required="required" value="{{ old('email') }}" autocomplete="off">
                                 @if ($errors->has('company_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('company_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="name" class="input-label">Country</label>
                                {!! Form::select('country',[null=>"Select Country Name"]+ $country_arr,null, 
                                    array('onchange'=>'change_country(this.value)','id' => 'country','class' => 'form-control','required')) !!}

                                    @if ($errors->has('country'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('country') }}</strong>
                                        </span>
                                    @endif
                            </div>
                            <div class="form-group{{ $errors->has('provience') ? ' has-error' : '' }}">
                                <label for="provience" class="input-label">Stata/ Province </label>
                                {!! Form::select('provience',[null=>"Select Provience"],null, 
                                    array('id' => 'provience','class' => 'form-control','required')) !!}

                                    @if ($errors->has('provience'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('provience') }}</strong>
                                        </span>
                                    @endif
                            </div>
                            <div class="form-group{{ $errors->has('plan') ? ' has-error' : '' }}">
                                <label for="plan" class="input-label">Plan</label>
                                {!! Form::select('plan',[null=>"Chose Your Plan"]+$service_plan_arr,null, 
                                    array('id' => 'provience','class' => 'form-control','required')) !!}

                                    @if ($errors->has('provience'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('provience') }}</strong>
                                        </span>
                                    @endif
                            </div>
                            <div class="form-group">
                                <label for="name" class="input-label">Full Name</label>
                                <input type="text" id="name"  name="name" class="form-control" placeholder="Type User Name" required="required">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
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

                                 <input id="user_type" type="hidden" class="form-control" name="user_type" value="9" >
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="input-label">Choose Password</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="********" required="required">
                                <i  toggle="#password" class="fa fa-fw fa-eye toggle-password field-icon"></i>
                            </div>
                            <div class="form-group">
                                <label for="password" class="input-label">Retype Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="********" required="required">
                                <i toggle="#password" class="fa fa-fw fa-eye toggle-password field-icon"></i>
                            </div>
                            <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                                <label for="captcha" class="col-md-4 control-label" style="color:#fff">Captcha</label>

                                <div class="col-md-6">
                                    <div class="captcha" style="min-height:50px; position:relative">
                                        <span>{!! captcha_img() !!}</span>
                                        <button type="button" style="position:absolute;left:180px; top:10px" 
                                        class="btn btn-success btn-refresh" id="refresh_captcha">Refresh</button>
                                    </div>
                                    <br/>
                                    <input type="text" id="captcha" class="form-control" placeholder="Enter Captcha" name="captcha">
                                    @if ($errors->has('captcha'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('captcha') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block fxt-btn-fill" >
                                   Continue/ Sign Up <span style="color:#9ef0e5">(Step 01 of 05)<span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="fxt-footer">
                        <p>Already have an account?<a href="/login" class="switcher-text2 inline-text">Log In</a></p>
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
    $(document).ready(function(){
        $(".toggle-password").click(function(){
            var type = $("#password").attr('type');
          
            if(type=="password")
            {

                $(".toggle-password").css({"color": "green"});
                $("#password_confirmation").removeAttr("type").attr('type','text');
                $("#password").removeAttr("type").attr('type','text');
            }
            else
            {
                $(".toggle-password").css({"color": "#c5c5c5"});
                $("#password_confirmation").removeAttr("type").attr('type','password');
                $("#password").removeAttr("type").attr('type','password');
            }
            
        });
    });

    


</script>

</body>
</html>