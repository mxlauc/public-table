@extends('layouts.main')

@section('style')
@endsection

@section('script')
    <script>
        app.component('post-component', PostComponent);
        app.component('crear-publicacion-component', CrearPublicacionComponent);
        app.component('seccion-posts', SeccionPosts);
    </script>
@endsection

@section('content')
    @auth
        <crear-publicacion-component>
        </crear-publicacion-component>
    @endauth
    <seccion-posts></seccion-posts>

@endsection
