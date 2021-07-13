@extends('layouts.main')

@section('content')
    <div class="row justify-content-center">
        <div class="col col-12 col-md-10 col-lg-9 col-xl-7">
            <post-component
                usuario-nombre="{{$post->user->name}}"
                usuario-imagen="{{$post->user->avatar}}"
                post-id="{{$post->id}}"
                imagen="{{$post->imagen ? Storage::url($post->imagen) : ''}}"
                descripcion="{{$post->descripcion}}"
                fecha-creacion="{{$post->created_at}}"
                :show-post-page="true">
            </post-component>
        </div>
    </div>

@endsection

@section('script')
    <script>
        app.component('post-component', PostComponent);

    </script>
@endsection