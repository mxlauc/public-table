<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{env('APP_NAME')}}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Secular+One&display=swap" rel="stylesheet">

    <style>

        body {
            padding-top: 56px;
            background-color: #e5e5e5;
        }
    </style>
    @yield('style')
</head>
<body class="antialiased">
    @include('sections.header')
    <div class="container-fluid px-0 pb-5" id="app">
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        var app = Vue.createApp({
            provide(){
                return {
                    usuarioLoginImagen: "{{Auth::user()->avatar ?? ''}}",
                    usuarioLoginNombre: "{{Auth::user()->name ?? ''}}",
                    usuarioLoginId: "{{Auth::user()->id ?? false}}",
                };
            },
        });
    </script>
    @yield('script')
    <script>
        app.use(window.VWave);
        app.mount("#app");
    </script>
</body>
</html>
