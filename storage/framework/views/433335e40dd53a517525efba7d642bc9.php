<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="msapplication-tap-highlight" content="no">
    
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Event-App - Techzu</title>
    <link rel="icon" href="https://techzu.co/wp-content/uploads/2022/10/ZU-icon-150x150.png" sizes="32x32" />
    <link rel="icon" href="https://techzu.co/wp-content/uploads/2022/10/ZU-icon-300x300.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://techzu.co/wp-content/uploads/2022/10/ZU-icon-300x300.png" />

    <!------------CSS-------------->
    <link href="css/main.css" rel="stylesheet">
    <link href="<?php echo asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css'); ?>" media="all" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"  />
    <link href="css/glyphicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>


<body >

<div id="preloader" class="preloader">
    <div class='inner'>
        <div class='line1'></div>
        <div class='line2'></div>
        <div class='line3'></div>
    </div>
</div> 

<!-----------------Full Body Area Start------------------>   
<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
    

  <!----------Header Area-------->  
    <section class="app-header header-shadow" style="margin-bottom: 10px !important">
        <div class="app-header__logo" style="background-color:rgba(10, 3, 96, 0.81); height:100% ; width:280px;">
            <div class="logo-src mt-3" >
                <img src="https://techzu.co/wp-content/uploads/2022/10/Techzu-02.png" alt="" height="" width="200" style=" vertical-align:middle !important" />
                <h6 style="color:#fff" class="mx-4">Event App</h6>
                     
            </div>

         
      </div>
       
      <div class="app-header__mobile-menu">
          <div>
              <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                  <span class="hamburger-box">
                      <span class="hamburger-inner"></span>
                  </span>
              </button>
          </div>
      </div>
      <div class="app-header__menu">

          <span>
              <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                  <span class="btn-icon-wrapper">
                      <i class="fa fa-ellipsis-v fa-w-6"></i>
                  </span>
              </button>
          </span>
      </div>   
      <div class="app-header__content">
         <!--  <div class="div-redinet">
          </div> -->
          <div class="app-header-left">
          </div>
         
          <div class="app-header-right">
              <div class="header-btn-lg pr-0">
                  <div class="widget-content p-0">
                      <div class="widget-content-wrapper">
                          <div class="widget-content-left">
                              
                          </div>
                          
                          <div class="widget-content-right header-user-info ml-3">
                              <img class="media-object rounded-circle" style="border: 2px solid rgba(8, 102, 255, 1)" src="img/user_image/ashraful.jpg"  width="38" height="38">
                              <p style="font-size: 10px;color: rgba(0, 0, 0, 0.8);">Ashraful Islam</p>
                            
                          </div>
                      </div>
                  </div>
              </div>        
      </div>
  </section>        
         
  <!----------Sidebar and Panel Area--------> 
  <div class="app-main" id="app">
      <!----------Sidebar--------> 
        
        
      <!----------Main Panel Area--------> 
      <div class="app-main__outer" style="padding-left:0" >

          <section class="app-main__inner" >
           
              <div class="row"  style="min-height:800px" >
                  <div class="col-md-12 col-xl-12">
                     <router-view>
                       
                      


                     </router-view>
                      

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
                                  Design and Developed By:
                                  <a href="https://techzu.co" target="blank" class="nav-link">
                                      Ashraful Islam
                                  </a>
                              </li>
                          </ul>
                      </div>
                  </div>
              </div>
          </section> 

      </div>



  </div>

  
</div>
<!-----------------Full Body Area End------------------>   

<!------------Scripts-------------->
<?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>

<script type="text/javascript" src="js/main.js"></script>

<script type="text/javascript" src="<?php echo e(asset('js/popper.min.js')); ?>"></script>


<script>
    //after window is loaded completely 
    window.onload = function(){
        //hide the preloader
        document.querySelector(".preloader").style.display = "none";
    }

    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/serviceworker.js')
        .then(() => console.log('Service Worker Registered'));
    }

    
</script>

</body>
</html>
<?php /**PATH G:\WampServer\www\Development\EventApp\resources\views/dashboard.blade.php ENDPATH**/ ?>