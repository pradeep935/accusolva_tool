<?php
 $version = '1.1.17'; 
    $fevico_image = DB::table('settings')->where('param','fevico_image')->first();
    $loader_image = DB::table('settings')->where('param','loader_image')->first();
    $small_logo = DB::table('settings')->where('param','small_image')->first();
 ?> 
<!DOCTYPE html>
<html lang="en">
    
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
        <meta name="Author" content="Spruko Technologies Private Limited">
        
        <!-- Title -->
        <title> {{env('APP_NAME')}} </title>

        <!--- Favicon -->
        <link rel="icon" href="assets/img/brand/favicon.png" type="image/x-icon"/>

        <!--- Icons css -->
        <link href="assets/css/icons.css" rel="stylesheet">

        
        <!--- Right-sidemenu css -->
        <link href="assets/plugins/sidebar/sidebar.css" rel="stylesheet">

        <!--- Custom Scroll bar -->
        <link href="assets/plugins/mscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet"/>

        <!--- Style css -->
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/css/skin-modes.css" rel="stylesheet">

        <!--- Sidemenu css -->
        <link href="assets/css/sidemenu.css" rel="stylesheet">

        <!--- Animations css -->
        <link href="assets/css/animate.css" rel="stylesheet">
        
        <!--- Switcher css -->
        <link href="assets/switcher/css/switcher.css" rel="stylesheet">
        <link href="assets/switcher/demo.css" rel="stylesheet"> </head>
    
    <body class="main-body">

    <!-- Loader -->
        <div id="global-loader">
            <img src="{{url('/'.$loader_image->value)}}" class="loader-img" alt="Loader">
        </div>
        
        @yield('content')

        <!-- /main-signin-wrapper -->
        
        <!-- Back-to-top -->
        <a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

        <!--- JQuery min js -->
        <script src="assets/plugins/jquery/jquery.min.js"></script>

        <!--- Datepicker js -->
        <script src="assets/plugins/jquery-ui/ui/widgets/datepicker.js"></script>

        <!--- Bootstrap Bundle js -->
        <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!--- Ionicons js -->
        <script src="assets/plugins/ionicons/ionicons.js"></script>

        
        <!--- Moment js -->
        <script src="assets/plugins/moment/moment.js"></script>

        <!--- JQuery sparkline js -->
        <script src="assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

        <!--- Perfect-scrollbar js -->
        <script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="assets/plugins/perfect-scrollbar/p-scroll.js"></script>


        <!--- Rating js -->
        <script src="assets/plugins/rating/jquery.rating-stars.js"></script>
        <script src="assets/plugins/rating/jquery.barrating.js"></script>

        <!--- Custom Scroll bar Js -->
        <script src="assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js"></script>


        <!--- Sidebar js -->
        <script src="assets/plugins/side-menu/sidemenu.js"></script>


        <!--- Right-sidebar js -->
        <script src="assets/plugins/sidebar/sidebar.js"></script>
        <script src="assets/plugins/sidebar/sidebar-custom.js"></script>
        
        <!--- Eva-icons js -->
        <script src="assets/js/eva-icons.min.js"></script>

        <!--- Scripts js -->
        <script src="assets/js/script.js"></script>

        <!--- Custom js -->
        <script src="assets/js/custom.js"></script>
        
        <!--- Switcher js -->
        <script src="assets/switcher/js/switcher.js"></script>
    
    </body>

<!-- Mirrored from laravel.spruko.com/azira/leftmenu_light/signin by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 08 Sep 2023 16:46:54 GMT -->
</html>

