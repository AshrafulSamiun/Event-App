<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="msapplication-tap-highlight" content="no">
    <title>Softview Accounting</title>

    <!------------CSS-------------->
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
</head>

<body onautocomplete="off">

<div id="preloader" class="preloader">
    <div class='inner'>
        <div class='line1'></div>
        <div class='line2'></div>
        <div class='line3'></div>
    </div>
</div>

<section class="fxt-template-animation fxt-template-layout4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-12 ">
                <div class="fxt-bg-img" data-bg-image="images/tower.jpg" style='background-image: url("images/logo-png.png");'>
                    <div class="fxt-header">
                        <!-- <div class="fxt-transformY-50 fxt-transition-delay-1">
                            <a href="login-4.html" class="fxt-logo"><img src="img/logo-4.png" alt="Logo"></a>
                        </div> -->
                        <div class="fxt-transformY-50 fxt-transition-delay-2">
                            <h1>Softview Accounting</h1>
                        </div>
                        <div class="fxt-transformY-50 fxt-transition-delay-3">
                            <p>Welcome to Softview Accounting</p>
                        </div>
                    </div>
                    <ul class="fxt-socials">
                        <li class="fxt-facebook fxt-transformY-50 fxt-transition-delay-4"><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                        <li class="fxt-twitter fxt-transformY-50 fxt-transition-delay-5"><a href="#" title="twitter"><i class="fab fa-twitter"></i></a></li>
                        <li class="fxt-google fxt-transformY-50 fxt-transition-delay-6"><a href="#" title="google"><i class="fab fa-google-plus-g"></i></a></li>
                        <li class="fxt-linkedin fxt-transformY-50 fxt-transition-delay-7"><a href="#" title="linkedin"><i class="fab fa-linkedin-in"></i></a></li>
                        <li class="fxt-youtube fxt-transformY-50 fxt-transition-delay-8"><a href="#" title="youtube"><i class="fab fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-12 fxt-bg-color">
                <div class="fxt-content">
                    <div class="fxt-form">
                        <form class="form-horizontal" method="POST" action="{{ route('register') }}" style="margin-top:30px;">
                             {{ csrf_field() }}
                            <h1>Register Account</h1>
                           
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
                                <i toggle="#password" id="icon_password" class="fa fa-fw fa-eye toggle-password field-icon" onclick="change_password_type(1)"></i>
                            </div>
                            <div class="form-group">
                                <label for="password" class="input-label">Retype Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="********" required="required">
                                <i toggle="#password" id="icon_password_confirmation" class="fa fa-fw fa-eye toggle-password field-icon" onclick="change_password_type(2)"></i>
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
                                   Continue/ Sign Up (Step 1 of 5)
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
        
        //var country_code_arr = <?php echo json_encode($country_code_arr); ?>;
        //alert(country_code_arr[1]['code'])
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

    function change_password_type(type)
    {
        if(type==1)
        {
            if($("#password").attr('type')=="text")
            {
                document.getElementById('password').type = 'password';
                $("#icon_password").css("color","#c5c5c5");
            }
            else {
                document.getElementById('password').type = 'text';
                $("#icon_password").css("color","#51d7c4");
            }
        }
        else if(type==2)
        {
            if($("#password_confirmation").attr('type')=="text")
            {
                document.getElementById('password_confirmation').type = 'password';
                $("#icon_password_confirmation").css("color","#c5c5c5");
            }
            else {
                document.getElementById('password_confirmation').type = 'text';
                $("#icon_password_confirmation").css("color","#51d7c4");
            }
        }
    }

    function change_country()
    {
        var country_id=$("#country").val();
        $("#country_code").val(country_id);
    }
</script>

</body>
</html>