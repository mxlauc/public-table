@extends('layouts.main')

@section('content')

@method('PUT')
@csrf
<user-header-component
    usuario-id="{{$user->id}}">
</user-header-component>


<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col col-12 col-md-9 col-lg-10 col-xl-8">
            <seccion-posts-component
                class-item="col-12 col-lg-6"
                url="/users/{{$user->id}}/posts">
            </seccion-posts-component>
        </div>
    </div>
</div>
@endsection
