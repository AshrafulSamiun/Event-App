<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="msapplication-tap-highlight" content="no">
    <title>NorthStar Property Management Technologies</title>
    <link href="images/logo_icon.png" rel="icon">

    <!------------CSS-------------->
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
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
    <div class="container-fluid">
           
            <div  id="msform">
                <div class="fxt-form">
                    <form class="form-horizontal" method="POST" action="{{ route('register_step_tow') }}" style="margin-top:30px;">
                    <div class="form-card">
                        <div class="form-folder">
                            <div class="form-holder">
                                <div class="row">
                                    <div class="col-md-4 col-12 fxt-bg-color">
                                        <div class="fxt-content form-holder">
                                               
                                            <h5 style=" color:#3E69D7; font-weight:bold; ">Registered Corporation Information</h5>
                                            <div class="form-group">
                                                <label for="corporation_name" class="input-label">Corporation Name</label>
                                                <input type="text" id="corporation_name"  name="corporation_name" class="form-control" placeholder="Type Corporation Name Address" required="required" value="{{ old('corporation_name') }}" autocomplete="off">
                                                 @if ($errors->has('corporation_name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('corporation_name') }}</strong>
                                                    </span>
                                                @endif

                                                 <input id="user_type" type="hidden" class="form-control" name="user_type" value="9" >
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
                                            <div class="form-group">
                                                <label for="city" class="input-label">City</label>
                                                 <input type="text" id="city"  name="city" class="form-control" placeholder="Type City" required="required" value="{{ old('city') }}" autocomplete="off">
                                                 @if ($errors->has('city'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('city') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="street" class="input-label">Street Address</label>
                                                 <input type="text" id="street"  name="street" class="form-control" placeholder="Type Street Address" required="required" value="{{ old('street') }}" autocomplete="off">
                                                 @if ($errors->has('street'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('street') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="zip_code" class="input-label">Zip/Postal Code</label>
                                                 <input type="text" id="zip_code"  name="zip_code" class="form-control" placeholder="Type Zip/Postal Code" required="required" value="{{ old('zip_code') }}" autocomplete="off">
                                                 @if ($errors->has('zip_code'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('zip_code') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-block fxt-btn-fill" >
                                                   Continue<span style="color:#9ef0e5">(Step 02 of 05)<span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12 fxt-bg-color">
                                        <div class="fxt-content form-holder">
                                            
                                                     
                                            <h5 style=" color:#3E69D7; font-weight:bold; ">Contact</h5>
                                            <div class="form-group">
                                                <label for="office_phone" class="input-label">Office Phone</label>
                                                <input type="text" id="office_phone"  name="office_phone" class="form-control" placeholder="Type Office Phone" required="required" value="{{ old('office_phone') }}" autocomplete="off">
                                                 @if ($errors->has('office_phone'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('office_phone') }}</strong>
                                                    </span>
                                                @endif

                                            </div>
                                            <div class="form-group">
                                                <label for="mobile" class="input-label">Mobile Number</label>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="input-group">
                                                            <select  class="form-control" name="country_code"  id="country_code" style="width: 50px;" disabled>
                                                                <option value="" selected="selected"> Country Code</option>
                                                                @foreach($country_code_arr as $index=>$value)
                                                                    <option value="{{$index}}">{{$value['short_name']}}-{{$value['code']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                            
                                                        <input id="mobile"  name="mobile" type="mobile" class="form-control" placeholder="Type Mobile Number" value="{{ old('mobile') }}" required="required">
                                                        @if ($errors->has('mobile'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('mobile') }}</strong>
                                                            </span>
                                                        @endif
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="email" class="input-label">Email</label>
                                                 <input type="email" id="email"  name="email" class="form-control" placeholder="Type Email" required="required" value="{{ old('email') }}" autocomplete="off">
                                                 @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="fax" class="input-label">Fax</label>
                                                 <input type="text" id="fax"  name="fax" class="form-control" placeholder="Type Fax" required="required" value="{{ old('fax') }}" autocomplete="off">
                                                 @if ($errors->has('fax'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('fax') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="website" class="input-label">Website</label>
                                                 <input type="text" id="website"  name="website" class="form-control" placeholder="Type website Address" required="required" value="{{ old('website') }}" autocomplete="off">
                                                 @if ($errors->has('website'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('website') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12 fxt-bg-color">
                                        <div class="fxt-content form-holder">
                                            
                                                     
                                            <h5 style=" color:#3E69D7; font-weight:bold; ">Other</h5>
                                            <div class="form-group">
                                                <label for="name" class="input-label">User Type</label>
                                                {!! Form::select('user_type',[null=>"Select User Type"]+ $user_type_arr,null, 
                                                    array('id' => 'user_type','class' => 'form-control','required')) !!}

                                                    @if ($errors->has('user_type'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('user_type') }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="mobile" class="input-label"> Is above registered corporation is active?</label>
                                                <select  class="form-control" name="country_code"  id="country_code" style="width: 50px;" disabled>
                                                        <option value="" selected="selected"> Country Code</option>
                                                        @foreach($country_code_arr as $index=>$value)
                                                            <option value="{{$index}}">{{$value['short_name']}}-{{$value['code']}}</option>
                                                        @endforeach
                                                    </select>

                                            </div>

                                            <div class="form-group">
                                                <label for="email" class="input-label">Email</label>
                                                 <input type="email" id="email"  name="email" class="form-control" placeholder="Type Email" required="required" value="{{ old('email') }}" autocomplete="off">
                                                 @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="fax" class="input-label">Fax</label>
                                                 <input type="text" id="fax"  name="fax" class="form-control" placeholder="Type Fax" required="required" value="{{ old('fax') }}" autocomplete="off">
                                                 @if ($errors->has('fax'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('fax') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="website" class="input-label">Website</label>
                                                 <input type="text" id="website"  name="website" class="form-control" placeholder="Type website Address" required="required" value="{{ old('website') }}" autocomplete="off">
                                                 @if ($errors->has('website'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('website') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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

     function change_country()
    {
        var country_id=$("#country").val();
        $("#country_code").val(country_id);
        $.ajax({

          type:'GET',
          url:'/provience_by_country/'+country_id,
          success:function(data){
            $("#provience").html(data);
          }
        });
    }

    


</script>

</body>
</html>