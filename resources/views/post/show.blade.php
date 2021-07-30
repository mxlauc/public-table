@extends('layouts.main')

@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col col-12 col-md-10 col-lg-9 col-xl-7">
                <post-component
                    usuario-nombre="{{$post->user->name}}"
                    usuario-imagen="{{$post->user->avatar}}"
                    usuario-id="{{$post->user->id}}"
                    post-id="{{$post->id}}"
                    imagen="{{$post->imagen}}"
                    descripcion="{{$post->descripcion}}"
                    fecha-creacion="{{strtotime($post->created_at)}}"
                    :show-post-page="true">
                </post-component>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        app.component('post-component', PostComponent);
        app.component('notifications-component', NotificationsComponent);
    </script>
@endsection
