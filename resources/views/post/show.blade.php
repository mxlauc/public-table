@extends('layouts.main')

@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col col-12 col-md-10 col-lg-9 col-xl-7">
                <post-component
                    :show-post-page="true"
                    :post="{
                        id: {{$post->id}},
                        imagen: '{{$post->imagen}}',
                        descripcion: '{{$post->descripcion}}',
                        created_at: {{strtotime($post->created_at)}},
                        my_like: {{$post->myLike()}},
                        contador: {{$post->contador()}},
                        user: {
                            id: {{$post->user->id}},
                            name: '{{$post->user->name}}',
                            avatar: '{{$post->user->avatar}}',
                            user_name: '{{$post->user->user_name}}',
                            url: '{{$post->user->getUrl()}}'
                        }
                    }">
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
