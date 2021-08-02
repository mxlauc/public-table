@extends('layouts.main')

@section('style')
@endsection

@section('content')
    <div class="container pt-5">
        @guest
            @include('sections.banner_login')
        @endguest
        <seccion-posts-component></seccion-posts-component>
    </div>

@endsection
