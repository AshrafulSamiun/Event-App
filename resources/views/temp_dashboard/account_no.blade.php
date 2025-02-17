<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    


    <link href="{!! asset('plugins/fontawesome-free/css/all.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <link href="{!! asset('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') !!}"  rel="stylesheet" type="text/css" />

    <link href="{!! asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') !!}"  rel="stylesheet" type="text/css" />
    <link href="{!! asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') !!}"  rel="stylesheet" type="text/css" />
    <link href="{!! asset('plugins/jqvmap/jqvmap.min.css') !!}"  rel="stylesheet" type="text/css" />

    <link href="{!! asset('css/adminlte.min.css') !!}"  rel="stylesheet" type="text/css" />
    <link href="{!! asset('plugins/overlayScrollbars/css/OverlayScrollbars.css') !!}"  rel="stylesheet" type="text/css" />

    <link href="{!! asset('plugins/daterangepicker/daterangepicker.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <link href="{!! asset('plugins/summernote/summernote-bs4.css') !!}"  rel="stylesheet" type="text/css" />
    <link href="{!! asset('css/style.css') !!}" media="all" rel="stylesheet" type="text/css" />
    
    <link href="{!! asset('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700') !!}"  rel="stylesheet" type="text/css" />

    
  </head>
  <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

    <div class="wrapper" id="app">
        <!-- Navbar -->

        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
          <!-- Left navbar links -->


           
          

          <!-- Right navbar links -->
          <ul class="navbar-nav ml-auto">
            <!-- user info -->
            <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                <img src="{{asset('img/user2-160x160.jpg')}}" height="30" width="30" class="img-circle elevation-2" alt="User Image">
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a class="dropdown-item" href="/logout"><i class="ion ion-log-out"></i> Sign out</a>
                
              </div>
            </li>


            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">3</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                  <!-- Message Start -->
                  <div class="media">
                    <img src="{{asset('img/user1-128x128.jpg')}}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                    <div class="media-body">
                      <h3 class="dropdown-item-title">
                        Brad Diesel
                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                      </h3>
                      <p class="text-sm">Call me whenever you can...</p>
                      <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                    </div>
                  </div>
                  <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <!-- Message Start -->
                  <div class="media">
                    <img src="{{asset('img/user8-128x128.jpg')}}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                    <div class="media-body">
                      <h3 class="dropdown-item-title">
                        John Pierce
                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                      </h3>
                      <p class="text-sm">I got your message bro</p>
                      <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                    </div>
                  </div>
                  <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <!-- Message Start -->
                  <div class="media">
                    <img src="{{asset('img/user3-128x128.jpg')}}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                    <div class="media-body">
                      <h3 class="dropdown-item-title">
                        Nora Silvester
                        <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                      </h3>
                      <p class="text-sm">The subject goes here</p>
                      <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                    </div>
                  </div>
                  <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
              </div>
            </li>
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <i class="fas fa-envelope mr-2"></i> 4 new messages
                  <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <i class="fas fa-users mr-2"></i> 8 friend requests
                  <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                  <i class="fas fa-file mr-2"></i> 3 new reports
                  <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
              </div>
            </li>
            

            <li class="nav-item">
              <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
                  class="fas fa-th-large"></i></a>
            </li>

            
          </ul>
        </nav>


        

        <!-- /.navbar -->




        <aside class="main-sidebar sidebar-light-primary elevation-4 ">
          <!-- Brand Logo -->
          <a href="index3.html" class="brand-link">
            <img src="{{asset('/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Company Name  dssd</span>
          </a>

          <!-- Sidebar -->
          <div class="sidebar layout-navbar-fixed">
        

            <!-- Sidebar Menu -->
            <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

              @foreach ($main_menu_arr as $mid => $m_value)
                <li class="nav-item has-treeview ">

                  @if($m_value['menuRoute'])

                    <router-link to="/{{$m_value['menuRoute']}}" class="nav-link router-link" style="background-color:#007bff; color:#fff">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>{{ $m_value['menuName']}}</p>
                    </router-link>
                  @endif  
                </li>
                 @endforeach

               



             
              </ul>
            </nav>
            <!-- /.sidebar-menu -->
          </div>
          <!-- /.sidebar -->
        </aside>
        <div class="content-wrapper">
     
         
            
            <router-view></router-view>

              
            
        </div>
         
    </div>
     

 

  </body>

    <script type="text/javascript" src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>



    <script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    
 



</html>