<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="msapplication-tap-highlight" content="no">
    <title>.: BMS - Vancouver Property Management :.</title>

    <!------------CSS-------------->
    <link href="css/main.css" rel="stylesheet">
</head>

<body>

<div id="preloader" class="preloader">
    <div class='inner'>
        <div class='line1'></div>
        <div class='line2'></div>
        <div class='line3'></div>
    </div>
</div>

<!-----------------Full Body Area Start------------------>   
<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
    

<!------Header Area------>  
      
       
<!----------Sidebar and Panel Area--------> 
<div class="app-main">

<!----------Sidebar-------> 
  

<!----------Main Panel Area--------> 
<div class="app-main__outer">

<section class="app-main__inner">

    <!----------Page Title Area--------> 
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fa fa-user-plus"></i>
                </div>
                <div>Create Account
                    <div class="page-title-subheading">Please filled all required sessions by follow step by step to create account fully.
                    </div>
                </div>
            </div>   
        </div>
    </div> 
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="card">
                <form id="msform">
                    <!-- progressbar -->
                    <ul id="progressbar">
                        <?php $sl=1; ?>
                         @foreach ($main_menu_arr as $mid => $m_value)
                            <li class="<?php if($sl==1) echo "active"; ?>"> <strong>{{$sl}}/7<br><span>
                               @if($m_value['menuRoute'])

                                  <router-link :to="{ path: '/{{$m_value['menuRoute']}}', params: { id: 20 }}"
                                    class="router-link" >
                                    
                                      <p>{{ $m_value['menuName']}}</p>
                                  </router-link>

                                @endif 
                               </span> </strong>
                               </li>
                               <?php $sl++; ?>
                        @endforeach
                       
                    </ul>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>


                     <router-view></router-view>


                </form>
            </div>
        </div>
    </div>
</section>

<!----------Footer Area--------> 
<section class="app-wrapper-footer">
    <div class="app-footer">
        <div class="app-footer__inner">
            <div class="app-footer-right">
                <ul class="nav">
                    <li class="nav-item d-flex align-items-center">
                        
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section> 

</div>


</div>
</div>
<!-----------------Full Body Area End------------------->   

<!------------Scripts-------------->
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="js/main.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="js/step.js"></script>


<script>
    //after window is loaded completely 
    window.onload = function(){
        //hide the preloader
        document.querySelector(".preloader").style.display = "none";
    }
</script>
<style>
  .router-link{
    cursor:pointer;

  }


</style>


</body>
</html>
