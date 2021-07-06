<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            padding-top: 56px;
            background-color: #eee;
        }
    </style>
    @yield('style')
</head>
<body class="antialiased">
    @include('sections.header')
    <div class="container pt-5">
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('script')
</body>
</html>
