@extends('layouts.main')

@section('style')
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
