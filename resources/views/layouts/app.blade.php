<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/MyCss.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
                <div class="row w-100 row justify-content-between">
                    <div class="col"> <a class="btn btn-light btn-lg" href="{{ url('/') }}">
                            {{ config('app.name', 'Laravel') }}</a>
                    </div>
                    @if (Auth::guard('admin')->guest())
                        <div class="col"><a class="btn btn-success btn-lg" href="{{ route('admin.login') }}">Login</a></div>
                        <div class="col"><a class="btn btn-success btn-lg" href="{{ route('admin.register') }}">Register</a></div>
                    @else
                        <div class="col"> <a id="logout" class="btn btn-danger btn-lg text-right" href="{{ route('admin.logout') }}">LogOut</a></div>
                </div>
                    @endif
        </div>
    </nav>
    @include('menu')
    @include('flash')
    @yield('content')
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>