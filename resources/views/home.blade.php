@extends('layouts.main')

@section('style')
@endsection

@section('script')
    <script>
        app.component('crear-publicacion-component', CrearPublicacionComponent);
        app.component('seccion-posts-component', SeccionPosts);
        app.component('notifications-component', NotificationsComponent);
    </script>
@endsection

@section('content')
    <div class="container pt-5">
        @auth
        <crear-publicacion-component>
        </crear-publicacion-component>
        @endauth
        <seccion-posts-component></seccion-posts-component>
    </div>

@endsection
