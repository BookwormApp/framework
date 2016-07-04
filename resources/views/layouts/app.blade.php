<!DOCTYPE html>
<html lang="en">
<head>
    @section('meta')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @show

    <title>@yield('meta_title', 'Bookworm')</title>

    @section('fonts')
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
    @show

    @section('assets')
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    @show
</head>
<body id="app" class="{{ Auth::check() ? 'auth-account ' : 'auth-guest ' }}@yield('body_class')">
    @include('partials.header')

    @section('notice')
    <div class="container">
        @include('notice::all')
    </div>
    @show

    @yield('content')

    @section('footer')
         @include('partials.footer')
    @show

    @section('scripts')
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/core.min.js') }}"></script>
        <script src="{{ asset('assets/js/script.js') }}"></script>
    @show

    @yield('base')
</body>
</html>
