<template>
    <div>
        <a
            v-if="comentariosPaginador && comentariosPaginador.prev_page_url"
            class="text-muted fw-bold ms-2"
            style="font-size: 12px; text-decoration:none"
            role="button"
            @click="cargarMasComentarios"
        >
            Ver comentarios anteriores
        </a>
        <div >
            <transition-group name="grupo-comentarios">
                <comentario-component
                    v-for="comentario in comentarios"
                    :key="comentario.id"
                    :comentario="comentario">
                </comentario-component>
            </transition-group>
        </div>



        <div class="row g-0">
            <div class="col col-auto py-2 ps-2">
                <img v-bind:src="usuarioLoginImagen" class="imagenUsuario" />
            </div>
            <div class="col p-2">
                <div class="row g-0 contenedorTextarea">
                    <div class="col">
                        <span
                            v-bind:id="'cajaTexto' + postId"
                            class="textarea text-break"
                            contenteditable
                            ref="textarea"
                            @keydown="enviarComentario"
                        ></span>
                    </div>
                    <div class="col col-auto" style="color: #777">
                        <gif-picker-component @gif-seleccionado="recibirGif">
                        </gif-picker-component>
                    </div>
                </div>
            </div>
            <div class="col-12 p-3 position-relative" v-if="gifSeleccionado">
                <img :src="gifSeleccionado" class="w-100">
                <button
                    type="button"
                    class="btn-close bg-white shadow position-absolute top-0 end-0 m-4 p-2 rounded-circle"
                    aria-label="Close"
                    @click="gifSeleccionado=null"></button>
            </div>
        </div>
        <!-- Modal Eliminar comentario -->
        <div
            class="modal fade"
            v-bind:id="'eliminarComentarioModal' + postId"
            tabindex="-1"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Eliminar comentario</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3">
                            ¿Seguro que quieres eliminar este comentario?
                        </p>
                        <div class="row g-0">
                            <div class="col col-auto py-1 ps-2">
                                <img
                                    class="imagenUsuario"
                                    v-bind:src="
                                        comentarioAEliminar?.user.avatar
                                    "
                                />
                            </div>
                            <div class="col ps-2 pt-1 pb-1">
                                <div
                                    class="contenedorTextarea text-break p-2"
                                    style="font-size: 12px"
                                >
                                    <label class="fw-bold">{{
                                        comentarioAEliminar?.user.name
                                    }}</label>
                                    <p class="m-0">
                                        {{ comentarioAEliminar?.descripcion }}
                                    </p>
                                    <img :src="comentarioAEliminar?.gif_url" v-if="comentarioAEliminar?.gif_url" class="img-fluid rounded">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                            Cancelar
                        </button>
                        <button
                            type="button"
                            class="btn btn-danger"
                            @click="eliminarComentario">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                            </svg>
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Editar comentario -->
        <div
            class="modal fade"
            v-bind:id="'editarComentarioModal' + postId"
            tabindex="-1"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar comentario</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-0">
                            <div class="col col-auto py-2 ps-2">
                                <img
                                    v-bind:src="comentarioAEditar?.user.avatar"
                                    class="imagenUsuario"
                                />
                            </div>
                            <div class="col p-2">
                                <div class="contenedorTextarea">
                                    <span
                                    class="textarea text-break"
                                    contenteditable
                                    ref="textareaEditar"
                                    >
                                        {{ comentarioAEditar?.descripcion }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                            Cancelar
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="editarComentario">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                            </svg>
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ComentarioComponent from "./ComentarioComponent.vue";
import GifPickerComponent from "./GifPickerComponent.vue";
export default {
    components: {
        ComentarioComponent,
        GifPickerComponent,
    },
    data() {
        return {
            comentarios: [],
            comentariosPaginador: null,
            comentarioAEliminar: undefined,
            comentarioAEditar: undefined,
            gifSeleccionado: null
        };
    },
    inject: ["usuarioLoginImagen", "usuarioLoginNombre", "postId"],
    emits: ["contadorActualizado"],
    mounted() {
        axios({
            method: "get",
            url: `/posts/${this.postId}/comments`,
        })
            .then((response) => {
                this.$emit("contadorActualizado", response.data.total);
                this.comentariosPaginador = response.data;
                this.comentarios = response.data.data;
            })
            .catch((response) => {
                console.log(response);
            });

        var thisComponent = this;
        document
            .getElementById("eliminarComentarioModal" + this.postId)
            .addEventListener("show.bs.modal", function (event) {
                var idComentario = event.relatedTarget.getAttribute(
                    "data-bs-id-comentario"
                );
                thisComponent.buscarComentarioEliminar(idComentario);
            });
        document
            .getElementById("editarComentarioModal" + this.postId)
            .addEventListener("show.bs.modal", function (event) {
                var idComentario = event.relatedTarget.getAttribute(
                    "data-bs-id-comentario"
                );
                thisComponent.buscarComentarioEditar(idComentario);
            });
    },
    methods: {
        enviarComentario(e) {
            if (e.keyCode === 13 && !e.shiftKey) {
                e.preventDefault();

                let texto = new DOMParser().parseFromString(
                    this.$refs.textarea.innerHTML
                        .replaceAll("<br>", "\n")
                        .replaceAll("<div>", "\n<div>"),
                    "text/html"
                ).documentElement.textContent;

                /* AJAX request */
                axios({
                    method: "post",
                    url: `/posts/${this.postId}/comments`,
                    data: {
                        descripcion: texto,
                        gif_url: this.gifSeleccionado,
                    },
                })
                    .then((response) => {
                        this.$refs.textarea.innerHTML = "";

                        this.comentarios.push({
                            id: response.data.id,
                            user: {
                                avatar: this.usuarioLoginImagen,
                                name: this.usuarioLoginNombre,
                            },
                            descripcion: texto,
                            gif_url: this.gifSeleccionado,
                        });
                        this.gifSeleccionado = null;
                        this.$emit("contadorActualizado", response.data.count);
                    })

                    .catch((response) => {
                        console.log(response);
                    });
            }
        },
        cargarMasComentarios() {
            axios({
                method: "get",
                url: this.comentariosPaginador.prev_page_url,
            })
                .then((response) => {
                    this.comentariosPaginador = response.data;
                    this.comentarios = response.data.data.concat(
                        this.comentarios
                    );
                })
                .catch((response) => {
                    console.log(response);
                });
        },
        buscarComentarioEliminar(id) {
            this.comentarioAEliminar = this.buscar(id);
        },
        buscarComentarioEditar(id) {
            this.comentarioAEditar = this.buscar(id);
        },
        buscar(id) {
            return this.comentarios.find((comentario) => comentario.id == id);
        },
        eliminarComentario() {
            var modal = bootstrap.Modal.getOrCreateInstance(
                document.querySelector("#eliminarComentarioModal" + this.postId)
            );

            axios({
                method: "post",
                url: `/comments/${this.comentarioAEliminar.id}`,
                data: {
                    _method: "DELETE",
                },
            })
                .then((response) => {
                    var indice = this.comentarios.findIndex(
                        (comentario) =>
                            comentario.id == this.comentarioAEliminar.id
                    );
                    this.comentarios.splice(indice, 1);
                    modal.hide();
                    this.$emit("contadorActualizado", response.data.count);

                })

                .catch((response) => {
                    console.log(response);
                });
        },
        editarComentario() {
            var modal = bootstrap.Modal.getOrCreateInstance(
                document.querySelector("#editarComentarioModal" + this.postId)
            );
            let texto = new DOMParser().parseFromString(
                this.$refs.textareaEditar.innerHTML
                    .replaceAll("<br>", "\n")
                    .replaceAll("<div>", "\n<div>"),
                "text/html"
            ).documentElement.textContent;

            axios({
                method: "post",
                url: `/comments/${this.comentarioAEditar.id}`,
                data: {
                    _method: "PUT",
                    descripcion: texto,
                },
            })
                .then((response) => {
                    this.comentarioAEditar.descripcion = texto;
                    modal.hide();
                })

                .catch((response) => {
                    console.log(response);
                });
        },
        recibirGif(url){
            this.gifSeleccionado = url;
        }
    },
};
</script>

<style scoped>
.imagenUsuario {
    border-radius: 50%;
    height: 30px;
}
.contenedorTextarea{
    background-color: #eee;
    border-radius: 12px;
}
.textarea {


    outline: none;
    font-family: inherit;
    font-size: inherit;
    padding: 5px 10px;
    display: block;

    resize: none;
    min-height: 30px;

    font-size: 14px;
}

.textarea[contenteditable]:empty::before {
    content: "Escribe un comentario...";
    color: gray;
}


.grupo-comentarios-enter-active {
  transition: all 0.8s ease-in-out;

}

.grupo-comentarios-leave-active {
  transition: all 0.3s ease-in;
  position: absolute;
}

.grupo-comentarios-enter-from,
.grupo-comentarios-leave-to {
    transform: translateX(5px);
    opacity: 0;
    width: 100%;
}
.grupo-comentarios-move {
  transition: transform 0.5s ease-out;
}
</style>

