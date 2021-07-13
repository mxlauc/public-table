@extends('layouts.main')

@section('style')
@endsection

@section('script')
    <script>
        app.component('post-component', PostComponent);
        app.component('crear-publicacion-component', CrearPublicacionComponent);

    </script>
@endsection

@section('content')
    @auth
        <crear-publicacion-component>
        </crear-publicacion-component>
    @endauth
    <div class="row masonry-row justify-content-center">

        @foreach ($posts as $post)
            <div class="col col-12 col-md-6 col-lg-4 col-xl-3">
                <post-component
                    post-id="{{ $post->id }}"
                    usuario-nombre="{{ $post->user->name }}"
                    usuario-imagen="{{ $post->user->avatar }}"
                    @if ($post->imagen)
                    imagen="{{ Storage::url($post->imagen) }}"
                    @endif
                    descripcion="{{ $post->descripcion }}"
                    fecha-creacion="{{$post->created_at}}"
                    :show-post-page="false">
                </post-component>
            </div>
        @endforeach
    </div>
@endsection
