<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v3.0.0-alpha.1
* @link https://coreui.io
* Copyright (c) 2019 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->

<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- <link rel="icon" type="image/png" sizes="16x16" href="{{ asset("assets/favicon/favicon-16x16.png")}} ">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset("assets/favicon/favicon-32x32.png") }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset("assets/favicon/favicon-192x192.png") }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset("assets/favicon/favicon-512x512.png") }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset("assets/favicon/apple-touch-icon.png") }}">
    <link rel="manifest" href="{{ asset("assets/favicon/site.webmanifest") }}"> -->
    <meta name="theme-color" content="#ffffff">
    <!-- Icons-->
    <link href="{{ asset('css/free.min.css') }}" rel="stylesheet"> <!-- icons -->
    <link href="{{ asset('css/flag-icon.min.css') }}" rel="stylesheet"> <!-- icons -->
    <!-- Main styles for this application-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @yield('css')
    <link href="{{ asset('css/coreui-chartjs.css') }}" rel="stylesheet">




    <!-- Global site tag (gtag.js) - Google Analytics -->

  </head>



  <body class="c-app">
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
      <div class="c-sidebar-brand">
        <img class="c-sidebar-brand-full" src="{{ asset("assets/brand/logo11.png") }}" width="186" height="58" alt="Logo">
        <img class="c-sidebar-brand-minimized" src="{{ asset("assets/brand/logo222.png") }}" width="48" height="48" alt="Logo">
      </div>

          @yield('sidebar')

        <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
    </div>
      @include('layouts.shared.header')

      <div class="c-body">

        <main class="c-main" id="app">

          @yield('content')

        </main>
        @include('layouts.shared.footer')
      </div>
    </div>



    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('js/coreui.bundle.min.js') }}"></script>
    <script src="{{ asset('js/coreui-utils.js') }}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    @yield('javascript')




  </body>
</html>
