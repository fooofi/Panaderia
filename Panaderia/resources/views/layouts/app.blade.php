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
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset("assets/favicon/favicon-16x16.png")}} ">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset("assets/favicon/favicon-32x32.png") }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset("assets/favicon/favicon-192x192.png") }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset("assets/favicon/favicon-512x512.png") }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset("assets/favicon/apple-touch-icon.png") }}">
    <link rel="manifest" href="{{ asset("assets/favicon/site.webmanifest") }}">
    <meta name="theme-color" content="#ffffff">
    <!-- Icons-->
    <link href="{{ asset('css/free.min.css') }}" rel="stylesheet"> <!-- icons -->
    <link href="{{ asset('css/flag.min.css') }}" rel="stylesheet"> <!-- icons -->
    <!-- Main styles for this application-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/coreui-chartjs.css') }}" rel="stylesheet">

  
      
  </head>
  <body class="c-app flex-row align-items-center">

    @yield('content')

    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('js/coreui.bundle.min.js') }}"></script>

    @yield('javascript')

  </body>
</html>
