<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{env('APP_NAME')}}</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
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
    <div class="container-fluid px-0 pb-5" id="app">
        @include('sections.header')
        @guest
            @include('sections.login')
        @endguest

        @yield('content')
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        var app = Vue.createApp({
            provide(){
                return {
                    @auth
                    usuarioLogin: {
                        id: "{{Auth::user()->id ?? false}}",
                        nombre: "{{Auth::user()->name ?? ''}}",
                        avatar: "{{Auth::user()->avatar ?? ''}}",
                        url: "{{Auth::user()->getUrl() ?? ''}}",
                    },
                    @else
                    usuarioLogin: null,
                    @endauth
                };
            },
        });

        app.mixin(mixin);
        app.component('post-component', PostComponent);
        app.component('notifications-component', NotificationsComponent);
        app.component('user-header-component', UserHeaderComponent);
        app.component('crear-publicacion-component', CrearPublicacionComponent);
        app.component('seccion-posts-component', SeccionPosts);
        app.component('guide-component', GuideComponent);
        app.use(Lang);
        app.use(window.VWave);
        app.mount("#app");
    </script>
    @yield('script')
</body>
</html>
