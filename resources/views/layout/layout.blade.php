<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}"/>
    <title>Let's Jam</title>

    <!-- Web Font -->
    <link href="https://fonts.googleapis.com/css2?family=Spartan:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('css/LineIcons.2.0.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('css/animate.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/tiny-slider.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('css/glightbox.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('css/header.css')}}"/>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('extra-css')
</head>

<body>
{{--header--}}
<nav> </nav>
<!-- <aside th:replace="~{layout/menu :: menu}"></aside> -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    @include('layout.header', ['status'=> 'ciao'])

    <!-- Main content -->
    <div class="content">
        <div>
            @yield('content')
        </div>
    </div>
</div>

<!-- Main Footer -->
@include('layout.footer')
{{--<footer class="main-footer">--}}
{{--</footer>--}}

<!-- ========================= Scripts here ========================= -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/count-up.min.js')}}"></script>
<script src="{{asset('js/wow.min.js')}}"></script>
<script src="{{asset('js/tiny-slider.js')}}"></script>
<script src="{{asset('js/glightbox.min.js')}}"></script>
<script src="{{asset('js/imagesloaded.min.js')}}"></script>
<script src="{{asset('js/isotope.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
@stack('extra-js')
</body>

</html>
