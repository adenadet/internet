<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>St. Nicholas Hospital | @yield('title')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper" id="corner">
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container">
        <a href="https://saintnicholashospital.com" class="navbar-brand">
            <img src="{{asset('dist/img/snh_logo.png')}}" alt="St. Nicholas Hospital" class="brand-image img-circle"
                style="opacity: .8">
            <span class="brand-text font-weight-light">St. Nicholas Hospital</span>
        </a>
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item"><a href="https://saintnicholashospital.com" class="nav-link">Home</a></li>
                <li class="nav-item"><router-link to="/uk-tb-screening" class="nav-link">Book Appointment</router-link></li>
                <!--<li class="nav-item"><router-link to="/uk-tb-reschedule" class="nav-link">Reschedule Appointment</router-link></li>-->
                <li class="nav-item"><router-link to="/uk-tb-cancellation" class="nav-link">Appointment Cancellation</router-link></li>
            </ul>
        </div>

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            
        </ul>
        </div>
    </nav>
    <div class="content-wrapper">
        <div class="content">
            <div class="container">
                <router-view></router-view>
                <vue-progress-bar></vue-progress-bar>
            </div>
        </div>
    </div>
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline"></div>
        <strong>Copyright &copy; 2014- <?= date('Y'); ?> <a href="https://saintnicholashospital.com">St. Nicholas Hospital</a>.</strong> All rights reserved.
    </footer>
</div>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
</body>
</html>
