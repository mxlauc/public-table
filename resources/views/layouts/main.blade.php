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
    <div class="container-fluid px-0 pb-5" id="app">
        @include('sections.header')
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        var mixin = {
            methods: {
                timeAgo(date){
                    var ahora = Date.now();
                    var diferencia = (ahora/ 1000) - date;
                    if(diferencia < 60){
                        return "Hace un momento";
                    }else if(diferencia < 60 * 60){
                        var m = Math.trunc(diferencia / 60);
                        return `Hace ${m} minutos`;
                    }else if(diferencia < 60 * 60 * 24){
                        var h = Math.trunc(diferencia / 60 / 60);
                        return `Hace ${h} horas`;
                    }else if (diferencia < 60 * 60 * 24 * 4){
                        var d = Math.trunc(diferencia / 60 / 60 / 24);
                        return `Hace ${d} días`;
                    }else{
                        var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                        var fecha = new Date(date * 1000);
                        var d = fecha.getDate();
                        var m = meses[fecha.getMonth()];
                        var h = fecha.getHours();
                        var mm = fecha.getMinutes();
                        return ` ${d} de ${m} a las ${h}:${mm < 10 ? '0' + mm : mm}`;
                    }
                }
            }
        };
        var app = Vue.createApp({
            provide(){
                return {
                    usuarioLoginImagen: "{{Auth::user()->avatar ?? ''}}",
                    usuarioLoginNombre: "{{Auth::user()->name ?? ''}}",
                    usuarioLoginId: "{{Auth::user()->id ?? false}}",
                };
            },
        });
        app.mixin(mixin);
    </script>
    @yield('script')
    <script>
        app.use(window.VWave);
        app.mount("#app");
    </script>
</body>
</html>
