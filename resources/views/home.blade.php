@extends('layouts.main')

@section('style')
    <style>
        .fade-enter-active,
        .fade-leave-active {
            transition: opacity .5s;
        }

        .fade-enter,
        .fade-leave-to {
            opacity: 0;
        }

        /***********************************/
        .hola-enter-from {
            background-color: red;
        }

        .hola-enter-to {
            background-color: blue;
        }

        .hola-enter-active {
            transition: all 0.3s ease-out;

            background-color: yellow;
        }

        .hola-leave-from {
            background-color: red;
        }

        .hola-leave-to {
            background-color: blue;
        }

        .hola-leave-active {
            transition: all 0.3s ease-out;

            background-color: yellow;
        }

    </style>
@endsection

@section('script')
    <script>
        var app = Vue.createApp({
            data() {
                return {
                    imagenPreview: null,
                    show: true,
                    name: "hola",
                    groceryList: [{
                            id: 0,
                            text: 'Vegetables'
                        },
                        {
                            id: 1,
                            text: 'Cheese'
                        },
                        {
                            id: 2,
                            text: 'Whatever else humans are supposed to eat'
                        }
                    ]
                };
            },
            methods: {
                saludar(e) {
                    e.preventDefault();

                    var formData = new FormData(this.$refs.formCrear);

                    console.log(formData);

                    /* AJAX request */
                    axios({
                            method: "post",
                            url: "{{ route('posts.store') }}",

                            data: formData,

                            config: {
                                headers: {
                                    "Content-Type": "multipart/form-data"
                                }
                            }
                        })

                        /* handle success */
                        .then(response => {
                            this.ocultarModal();
                            console.log(response.data);
                        })

                        /* handle error */
                        .catch(response => {
                            console.log(response)
                        });
                },
                ocultarModal() {
                    var modalHTML = document.getElementById('exampleModal');
                    var myModal = window.bootstrap.Modal.getInstance(modalHTML);
                    let formulario = this.$refs.formCrear;
                    modalHTML.addEventListener('hidden.bs.modal', function(event) {
                        console.log(formulario.reset());
                    });
                    myModal.hide();
                    this.imagenPreview = null;
                },
                mostrarPreview(e) {
                    this.imagenPreview = URL.createObjectURL(e.target.files[0]);
                    console.log(URL.createObjectURL(e.target.files[0]));
                }
            }
        });
        // Define a new component called todo-item
        app.component('todo-item', {
            props: ['todo'],
            template: `<li>@{{ todo . text }}</li>`
        });
        app.component('example-component', window.ExampleComponent);
        app.mount("#app");

    </script>
    <script>
        window.addEventListener('load', function() {
            var elem = document.querySelector('.masonry-row');
            var msnry = new Masonry(elem, {
                // options
                percentPosition: true
            });
        });

    </script>
@endsection

@section('content')
    <div id="app">


        @auth
        <div class="row justify-content-center">
            <div class="col col-8">
                <label class="form-control text-muted mb-5" role="button" tabindex="0" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    Publicar algo...
                </label>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content" style="box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1)">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Crear publicación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div class="mb-2">
                                <label>
                                    <img src="{{Auth::user()->avatar}}"
                                        class="rounded-circle" style="height: 40px;">
                                    {{Auth::user()->name}}
                                </label>
                            </div>
                            <form action="{{ route('posts.store') }}" @submit.prevent="saludar" ref="formCrear" method="POST">
                                @csrf
                                <textarea name="descripcion"
                                    style="width: 100%; height: 100px; resize: none; border: 0px; outline: none;"
                                    placeholder="¿En qué estas pensando?"></textarea>
                                <input type="file" name="imagen" id="imagen" class="d-none" @change="mostrarPreview">
                            </form>

                            <img v-bind:src="imagenPreview" class="w-100" v-if="imagenPreview">

                            <label for="imagen" class="form-control" tabindex="0" role="button" v-else>
                                <img src="https://img.icons8.com/cotton/2x/image-file-add--v2.png" style="height: 20px">
                                Agregar imagen
                            </label>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary w-100 mt-2" data-bs-dismiss="modal"
                            @click="saludar">Publicar</button>
                    </div>
                </div>
            </div>
        </div>

        @endauth



        <div class="row masonry-row">

            @foreach ($posts as $post)
                <div class="col col-12 col-md-6 col-lg-4 col-xl-3">
                    <example-component usuario-nombre="{{ $post->user->name }}" usuario-imagen="{{ $post->user->avatar }}"
                        @if ($post->imagen) imagen="{{ Storage::url($post->imagen) }}" @endif
                        descripcion="{{ $post->descripcion }}"></example-component>
                </div>

            @endforeach

        </div>


    </div>
@endsection
