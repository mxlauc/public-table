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
        var mixin = {
            methods: {
                timeAgo(date){

                    var ahora = Date.now();
                    var diferencia = (ahora/ 1000) - date;
                    if(diferencia < 60){
                        return this.__('A moment ago');
                    }else if(diferencia < 60 * 60){
                        var m = Math.trunc(diferencia / 60);
                        return m == 1
                            ? this.__('A minute ago')
                            : this.__('minutes ago', {minutes: m});
                    }else if(diferencia < 60 * 60 * 24){
                        var h = Math.trunc(diferencia / 60 / 60);
                        return h == 1
                            ? this.__('A hour ago')
                            : this.__('hours ago', {hours: h});
                    }else if (diferencia < 60 * 60 * 24 * 4){
                        var d = Math.trunc(diferencia / 60 / 60 / 24);
                        return d == 1
                            ? this.__('A day ago')
                            : this.__('days ago', {days: d});
                    }else{
                        var meses = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                        var fecha = new Date(date * 1000);
                        var d = fecha.getDate();
                        var m = meses[fecha.getMonth()];
                        var h = fecha.getHours();
                        var y = fecha.getFullYear();
                        var mm = fecha.getMinutes();
                        return this.__('date', {year: y, month: this.__(m), day:d, hours: h, minutes: mm < 10 ? '0' + mm : mm});
                    }
                },
                mostrarLoginModal(){
                    var modal = bootstrap.Modal.getOrCreateInstance(document.querySelector('#loginModal'));
                    modal.show();
                }
            }
        };
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
    </script>
    @yield('script')
    <script>
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
</body>
</html>
