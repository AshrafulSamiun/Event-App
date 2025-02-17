<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Accounting application</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
 
 <!-- <link href="{!! asset('css/bootstrap.min.css') !!}" media="all" rel="stylesheet" type="text/css" />-->
  <!-- Font Awesome -->
  
  <link href="{!! asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Theme style -->
  <link href="{!! asset('css/bootstrap.css') !!}" media="all" rel="stylesheet" type="text/css" />


  <link href="{!! asset('css/style.css') !!}" media="all" rel="stylesheet" type="text/css" />

  
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link href="{!! asset('css/ionicon.css') !!}" media="all" rel="stylesheet" type="text/css" />

  <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/cloudeState.js') }}"></script>

   <link href="{!! asset('tailSelect/css/bootstrap4/tail.select-primary.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
   
  <script type="text/javascript" src="{{ asset('tailSelect/js/tail.select.min.js') }}"></script>

</head>
<body>

<div class="wrapper">
    <nav class="navbar navbar-spark navbar-toggleable navbar-expand-md">
        <div class="container-fluid">
        <button type="button" class="sidebar-open d-lg-none">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand d-none d-lg-inline-block" href="https://bmtf.com.bd" target="_blank">
          <img class="media-object img-circle" src="{{asset('img/bmtf_logo.png')}}" width="38" height="38">
        </a>
    

        


        <ul class="nav navbar-nav navbar-right">
      

          
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Profile</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#"><i class="ion ion-person"></i> View Profile</a></li>
              <li><a class="dropdown-item" href="#"><i class="ion ion-chatbubbles"></i> Contacts</a></li>
              <li><a class="dropdown-item" href="#"><i class="ion ion-email"></i> Mailbox</a></li>
              <li><a class="dropdown-item" href="#"><i class="ion ion-gear-b"></i> Settings</a></li>
              <li role="separator" class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="/logout"><i class="ion ion-log-out"></i> Sign out</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Messages</a>
            <div class="dropdown-menu dropdown-md">

              <div class="media-items">
                <div class="media">
                  <div class="media-left mr-1">
                    <a href="#">
                      <img class="media-object img-circle" src="{{asset('img/avatar-500x500.png')}}" width="38" height="38">
                    </a>
                  </div>
                  <div class="media-body text-muted">
                    <p class="media-heading">Linda Miller</p>
                    <span class="text-sm">Aenean posuere, tortor sed..</span>
                  </div>
                </div>

                <div class="media">
                  <div class="media-left mr-1">
                    <a href="#">
                      <img class="media-object img-circle" src="{{asset('img/avatar-500x500-2.png')}}" width="38" height="38">
                    </a>
                  </div>
                  <div class="media-body text-muted">
                    <p class="media-heading">Kathie Burton</p>
                    <span class="text-sm">Nam pretium turpis et arcu..</span>
                  </div>
                </div>

                <div class="media">
                  <div class="media-left mr-1">
                    <a href="#">
                      <img class="media-object img-circle" src="{{asset('img/avatar-500x500.png')}}" width="38" height="38">
                    </a>
                  </div>
                  <div class="media-body text-muted">
                    <p class="media-heading">Linda Miller</p>
                    <span class="text-sm">Aenean posuere, tortor sed..</span>
                  </div>
                </div>

                <div class="media">
                  <div class="media-left mr-1">
                    <a href="#">
                      <img class="media-object img-circle" src="{{asset('img/avatar-500x500-2.png')}}" width="38" height="38">
                    </a>
                  </div>
                  <div class="media-body text-muted">
                    <p class="media-heading">Kathie Burton</p>
                    <span class="text-sm">Nam pretium turpis et arcu..</span>
                  </div>
                </div>
              </div>

              <a class="dropdown-menu-footer" href="#">
                View all
              </a>

            </div>
          </li>

          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tasks</a>
            <div class="dropdown-menu dropdown-menu-right dropdown-md last-dropdown">

              <div class="dropdown-task text-muted">
                <div class="pull-right text-sm">50%</div>
                Google Chrome Extension
                <div class="progress">
                  <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <div class="dropdown-task text-muted">
                <div class="pull-right text-sm">90%</div>
                Bootstrap Admin Theme
                <div class="progress">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <div class="dropdown-task text-muted">
                <div class="pull-right text-sm">33%</div>
                YouTube Client
                <div class="progress">
                  <div class="progress-bar bg-danger" role="progressbar" style="width: 33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <div class="dropdown-task text-muted">
                <div class="pull-right text-sm">40%</div>
                Form Validation
                <div class="progress">
                  <div class="progress-bar" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <a class="dropdown-menu-footer" href="#">
                View all
              </a>

            </div>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <img src="{{asset('img/avatar-500x500.png')}}" alt="Avatar" class="avatar img-circle" width="48" height="48">
            </a>
          </li>
        </ul>
        </div>
    </nav>
    <div class="content">
      <header class="page-header">
        <div class="container-fluid">
          <div class="row">
        
         
          </div>
        </div>
      </header>

      <div class="page-body" id="app">
        <div class="container-fluid">
          <div class="page-sidebar toggled sidebar">
            <nav class="sidebar-collapse d-none d-lg-block">
              <i class="ion ion-ios-arrow-forward show-on-collapsed"></i>
              <i class="ion ion-ios-arrow-back hide-on-collapsed"></i>
            </nav>
            <div id="dynamic_left_sidear" >
               <ul class="nav nav-pills nav-stacked" id="sidebar-stacked">
                <li class="d-lg-none">
                  <a href="#" class="sidebar-close"><i class="ion ion-ios-arrow-left"></i></a>
                </li>

                @foreach ($main_menu_arr as $mid => $m_value)
                <li class="nav-item has-treeview ">

                  @if($m_value['menuRoute'])

                    <router-link :to="{ path: '/{{$m_value['menuRoute']}}', params: { id: 20 }}"
                      class="nav-link router-link" style="background-color:#007bff; color:#fff">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>{{ $m_value['menuName']}}</p>
                    </router-link>

                    <router-link :to="{ path: '/{{$m_value['menuRoute']}}', params: { id: 20 }}">
                    <i class="ion ion-ios-circle-outline"></i>
                    &nbsp;&nbsp;{{ $m_value['menuName']}}</router-link>

                  @endif  
                </li>
                 @endforeach

                    

                      
                </ul> 
            </div>
            <!-- dynamic_left_sidear -->

          </div>
          <!-- page-sidebar toggled sidebar -->
          <div class="page-content" > 
            
              <router-view></router-view>
                
          </div>        
        </div>

        <!-- container-fluid -->


      </div>
      <!-- page-body -->

    </div>
    <!-- content -->
  </div>
  <!-- wrapper -->
</body>


 <script src="{{ asset('js/app.js') }}"></script>



<script type="text/javascript" src="{{ asset('js/wow.min.js') }}"></script>


<script type="text/javascript">
    new WOW().init();
    tail.select(".select");

   function module_selection(module_id)
   {
      // $("#dynamic_left_sidear").load("leftMenuByModule/"+module_id, function(responseTxt, statusTxt, xhr){
      //   if(statusTxt == "success")
      //     alert("External content loaded successfully!");return;
      //   if(statusTxt == "error")
      //     alert("Error: " + xhr.status + ": " + xhr.statusText);return;
      // });



      $.ajax({
        type: 'GET', 
        url: 'leftMenuByModule/'+module_id,
      //  dataType: 'json',
        success: function (result) {
            alert();
            $("#dynamic_left_sidear").html('');
            $("#dynamic_left_sidear").html(result);
          
        },error:function(){ 
             console.log(data);
        }
      });
   }

</script>
<link href="{!! asset('css/glyphicon.css') !!}" media="all" rel="stylesheet" type="text/css" />
</html>