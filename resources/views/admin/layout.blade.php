<?php
 $version = '1.1.20'; 
    $fevico_image = DB::table('settings')->where('param','fevico_image')->first();
    $loader_image = DB::table('settings')->where('param','loader_image')->first();
    $small_logo = DB::table('settings')->where('param','small_image')->first();
 ?> 

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Title -->
    <title> {{env('APP_NAME')}} </title>

    <!--- Favicon -->
    <link rel="icon" href="{{url('/'.$fevico_image->value)}}" type="image/x-icon"/>

    <!--- Icons css -->
    <link href="{{url('/assets/css/icons.css')}}" rel="stylesheet">

    <!-- Owl-carousel css-->
<link href="{{url('/assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet"/>

    <!--- Right-sidemenu css -->
    <link href="{{url('/assets/plugins/sidebar/sidebar.css')}}" rel="stylesheet">

    <!--- Custom Scroll bar -->
    <link href="{{url('/assets/plugins/mscrollbar/jquery.mCustomScrollbar.css')}}" rel="stylesheet"/>
    <link href="{{url('/assets/jquery_ui/jquery-ui.min.css')}}" rel="stylesheet"/>
    <link href="{{url('/assets/jquery_ui/jquery-ui.theme.min.css')}}" rel="stylesheet"/>

    <!--- Style css -->
    <link href="{{url('/assets/css/style.css')}}" rel="stylesheet">
    <link href="{{url('/assets/css/skin-modes.css')}}" rel="stylesheet">

    <!--- Animations css -->
    <link href="{{url('/assets/css/animate.css')}}" rel="stylesheet">
    
    <!--- Switcher css -->
    <link href="{{url('/assets/switcher/css/switcher.css')}}" rel="stylesheet">
    <link href="{{url('/assets/switcher/demo.css')}}" rel="stylesheet"> </head>

  <body class="main-body  app" ng-app="app">

    <div id="global-loader">
      <img src="{{url('/'.$loader_image->value)}}" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->

    <!-- main-header opened -->
    <div class="main-header nav nav-item hor-header">
      <div class="container">
        <div class="main-header-left ">
          <a class="animated-arrow hor-toggle horizontal-navtoggle"><span></span></a><!-- sidebar-toggle-->
          <a class="header-brand" href="{{url('/dashboard')}}">
            <img src="{{url('/'.$small_logo->value)}}" class="logo-white ">
            <img src="{{url('/'.$small_logo->value)}}" class="logo-default">
            <img src="{{url('/'.$small_logo->value)}}" class="icon-white">
            <img src="{{url('/'.$small_logo->value)}}" class="icon-default">
          </a>
          <div class="main-header-center  ml-4">

          </div>
        </div>
      </div>
    </div>
    @include('admin.sidebar')
    <div class="main-content horizontal-content">
      @yield('content')
      <script type="text/javascript">
        var base_url = "{{url('/')}}";
        var CSRF_TOKEN = "{{ csrf_token() }}";
      </script>
    </div>
    <a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
    <script src="{{url('/assets/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{url('/assets/jquery_ui/jquery-ui.min.js')}}"></script>

    <script src="{{url('/assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <script src="{{url('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{url('/assets/plugins/ionicons/ionicons.js')}}"></script>
    <script src="{{url('/assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
    <script src="{{url('/assets/js/index.js')}}"></script>
    <script src="{{url('/assets/js/sticky.js')}}"></script>
    <script src="{{url('/assets/js/horizontal-menu.js')}}"></script>
    <script src="{{url('/assets/plugins/sidebar/sidebar.js')}}"></script>
    <script src="{{url('/assets/plugins/sidebar/sidebar-custom.js')}}"></script>
    <script src="{{url('/assets/js/eva-icons.min.js')}}"></script>
    <script src="{{url('/assets/js/script.js')}}"></script>
    <script src="{{url('/assets/js/custom.js')}}"></script>
    <script src="{{url('/assets/switcher/js/switcher.js')}}"></script>  
    <script src="{{url('assets/plugins/bootbox/bootbox.min.js?v='.$version)}}" type="text/javascript"></script>

    <script type="text/javascript" src="{{url('assets/js/angular.min.js?v='.$version)}}" ></script>
    <script type="text/javascript" src="{{url('assets/js/angular-sanitize.js?v='.$version)}}" ></script>
    <script type="text/javascript" src="{{url('scripts/ng-file-upload.min.js?v='.$version)}}" ></script>
    <script type="text/javascript" src="{{url('scripts/ng-file-upload-shim.min.js?v='.$version)}}" ></script>
    <script type="text/javascript" src="{{url('assets/js/jcs-auto-validate.js?v='.$version)}}" ></script>
    <script src="{{url('assets/js/custom.js?v='.$version)}}"></script>

    <script type="text/javascript" src="{{url('scripts/core/app.js?v='.$version)}}" ></script>
    <script type="text/javascript" src="{{url('scripts/core/app_front.js?v='.$version)}}" ></script>
    <script type="text/javascript" src="{{url('scripts/core/services.js?v='.$version)}}" ></script>
    <script type="text/javascript" src="{{url('scripts/core/controllers.js?v='.$version)}}" ></script>
  </body>
</html>