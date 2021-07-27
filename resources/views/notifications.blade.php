@extends('layouts.main')

@section('content')
<div class="container pt-5">
    @foreach ($notificaciones as $notificacion)
        @if ($notificacion->type == 'App\Notifications\NewFollower')
            @php
            $user = json_decode($notificacion->data)->user;
            @endphp
            <div class="row">
                <div class="col col-auto">
                    <img src="{{$user->avatar}}" class="rounded-circle" style="height:60px">
                </div>
                <div class="col">
                    <p>
                        <span class="fw-bold">{{$user->nombre}}</span> empezó a seguirte.
                    </p>
                </div>
            </div>
        @elseif ($notificacion->type == 'App\Notifications\NewLike')
            @php
            $user = json_decode($notificacion->data)->user;
            @endphp
            <div class="row">
                <div class="col col-auto">
                    <img src="{{$user->avatar}}" class="rounded-circle" style="height:60px">
                </div>
                <div class="col">
                    <p>
                        A <span class="fw-bold">{{$user->nombre}}</span> le gusto tu publicación.
                    </p>
                </div>
            </div>
        @elseif ($notificacion->type == 'App\Notifications\NewComment')
            @php
            $user = json_decode($notificacion->data)->user;
            @endphp
            <div class="row">
                <div class="col col-auto">
                    <img src="{{$user->avatar}}" class="rounded-circle" style="height:60px">
                </div>
                <div class="col">
                    <p>
                        <span class="fw-bold">{{$user->nombre}}</span> comentó tu publicación.
                    </p>
                </div>
            </div>
        @elseif ($notificacion->type == 'App\Notifications\NewPostFollowed')
            @php
            $user = json_decode($notificacion->data)->user;
            @endphp
            <div class="row">
                <div class="col col-auto">
                    <img src="{{$user->avatar}}" class="rounded-circle" style="height:60px">
                </div>
                <div class="col">
                    <p>
                        <span class="fw-bold">{{$user->nombre}}</span> acaba de subir una nueva publicación.
                    </p>
                </div>
            </div>
        @endif



    @endforeach

    @json($notificaciones)
</div>
@endsection
