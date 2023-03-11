<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/angular.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/date.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    {{--<script src="{{ asset('js/bootstrap.min.js') }}"></script>--}}
    <script src="{{ asset('js/bootbox.min.js') }}" ></script>


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/css.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">

<!--    fonts-->
    <link href="{{ asset('css/fa-brands.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fa-regular.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fa-solid.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome-all.css') }}" rel="stylesheet">


</head>
{{--<body>--}}
{{--<div id="app">--}}
    {{--@guest--}}
        {{--@else--}}
    {{--<nav class="navbar navbar-expand-md navbar-light navbar-laravel">--}}
        {{--<div class="container">--}}
            {{--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"--}}
                    {{--aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">--}}
                {{--<span class="navbar-toggler-icon"></span>--}}
            {{--</button>--}}
            {{--<div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
                {{--<ul class="navbar-nav mr-auto">--}}
                    {{--<a class="nav-link" href="/home" role="button"--}}
                       {{--aria-haspopup="true" aria-expanded="false" v-pre>--}}
                        {{--Home <span class="fa fa-home"></span>--}}
                    {{--</a>--}}
                {{--</ul>--}}

                {{--<!-- Right Side Of Navbar -->--}}
                {{--<ul class="navbar-nav ml-auto">--}}
                    {{--<!-- Authentication Links -->--}}
                    {{--@guest--}}
                                             {{--<li><a class="nav-link" href="{{ route('register') }}">{{ __('Login') }}</a></li>--}}
                    {{--@else--}}
                    {{--<li class="nav-item">--}}

                    {{--</li>--}}
                    {{--<li class="nav-item dropdown">--}}

                        {{--<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"--}}
                           {{--data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>--}}
                            {{--{{ Auth::user()->name }} <span class="fa fa-user"></span>--}}
                        {{--</a>--}}

                        {{--<div class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
                            {{--<a class="dropdown-item" href="#">--}}
                                {{--{{ __('Profile') }}--}}
                            {{--</a>--}}
                            {{--<a class="dropdown-item" href="{{ route('logout') }}"--}}
                               {{--onclick="event.preventDefault();--}}
                                                     {{--document.getElementById('logout-form').submit();">--}}
                                {{--{{ __('Logout') }}--}}
                            {{--</a>--}}
                            {{--<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
                                {{--@csrf--}}
                            {{--</form>--}}
                        {{--</div>--}}

                    {{--</li>--}}

                    {{--@endguest--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</nav>--}}
    {{--@endguest--}}
    {{--<main class="py-4">--}}
        {{--@yield('content')--}}
    {{--</main>--}}
{{--</div>--}}
{{--</body>--}}

</html>
