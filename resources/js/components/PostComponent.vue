<template>
    <!-- Modal Ver Likes -->
    <div
        class="modal fade"
        v-bind:id="'likesPost' + postId"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">A estas personas les gusto tu publicación</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <div class="row g-0 usuarioItem" v-for="like in likes" v-bind:key="like.id">
                        <div class="col col-auto py-1 ps-2">
                            <img v-bind:src="like.user.avatar" class="imagenUsuario" />
                        </div>
                        <div class="col ps-2 pt-2 pb-1 fw-bold">
                            <span style="font-size:16px;">{{like.user.name}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Eliminar Post -->
    <div
        class="modal fade"
        v-bind:id="'eliminarPostModal' + postId"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Eliminar Publicación</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">
                        ¿Seguro quieres eliminar esta publicación?
                    </p>
                    <div
                        class="card"
                        style="box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1)"
                    >
                        <div class="card-body">
                            <div class="row g-0">
                                <div class="col col-auto">
                                    <img
                                        v-if="usuarioImagen"
                                        v-bind:src="usuarioImagen"
                                        class="rounded-circle"
                                        :class="{
                                            imgGrande: showPostPage,
                                            imgPequeno: !showPostPage,
                                        }"
                                    />
                                </div>
                                <div class="col px-2">
                                    <p
                                        class="fw-bold m-0 p-0"
                                        :class="{
                                            'text-16': showPostPage,
                                            'text-12': !showPostPage,
                                        }"
                                    >
                                        {{ usuarioNombre }}
                                    </p>
                                    <a
                                        v-bind:href="'/posts/' + postId"
                                        class="d-block text-muted m-0 p-0"
                                        :class="{
                                            'text-13': showPostPage,
                                            'text-10': !showPostPage,
                                        }"
                                        >Hace 12 horas</a
                                    >
                                </div>
                            </div>
                            <hr class="my-2" />
                            <p
                                class="card-text"
                                :style="{ fontSize: fontSize + 'px' }"
                            >
                                {{ descripcion }}
                            </p>
                        </div>

                        <div class="text-center">
                            <img
                                v-bind:src="imagen"
                                class="img-fluid"
                                v-if="imagen"
                                :class="{ maxHeight450: showPostPage }"
                            />
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
                    <button type="button" class="btn btn-danger" @click="eliminarPublicacion">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                        </svg>
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div
        class="card mb-4 cardPostInvisible" :class="{cardPostVisible : false}"
        style="box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1)"
        ref="card"
    >
        <div class="card-body pb-2">
            <div class="row g-0">
                <div class="col col-auto">
                    <a :href="usuarioUrl">
                        <img
                        v-if="usuarioImagen"
                        v-bind:src="usuarioImagen"
                        class="rounded-circle"
                        :class="{
                            imgGrande: showPostPage,
                            imgPequeno: !showPostPage,
                        }">
                    </a>
                </div>
                <div class="col px-2">
                    <a
                        :href="usuarioUrl"
                        class="fw-bold m-0 p-0 text-decoration-none text-dark"
                        :class="{
                            'text-16': showPostPage,
                            'text-12': !showPostPage,
                        }"
                    >
                        {{ usuarioNombre }}
                    </a>
                    <a
                        style="text-decoration:none"
                        v-bind:href="'/posts/' + postId"
                        class="d-block text-muted m-0 p-0"
                        :class="{
                            'text-13': showPostPage,
                            'text-10': !showPostPage,
                        }">
                        {{fechaCreacionDisplay}}
                        </a
                    >
                </div>
                <div class="col col-auto">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        class="py-2 px-2"
                        style="width: 32px; color:#888;"
                        viewBox="0 0 16 16"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                    <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                    </svg>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li>
                            <a
                                class="dropdown-item"
                                type="button"
                                v-bind:href="'/posts/' + postId"
                            >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-right-square" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm5.854 8.803a.5.5 0 1 1-.708-.707L9.243 6H6.475a.5.5 0 1 1 0-1h3.975a.5.5 0 0 1 .5.5v3.975a.5.5 0 1 1-1 0V6.707l-4.096 4.096z"/>
                            </svg>
                                Ver publicación
                            </a>
                        </li>
                        <li>
                            <button class="dropdown-item" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                                Editar publicación
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item" type="button" data-bs-toggle="modal" v-bind:data-bs-target="'#eliminarPostModal' + postId">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                </svg>
                                Eliminar publicación
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="my-2" v-if="descripcion">
            <p class="card-text" :style="{ fontSize: fontSize + 'px' }" style="white-space:pre-wrap;" v-if="descripcion">
                {{mostrarDescripcion}}
                <span class="fw-bold" role="button" @click="isTextoTruncado=false" v-if="truncarTexto && isTextoTruncado">(Ver más)</span>
                <span class="fw-bold" role="button" @click="isTextoTruncado=true" v-if="truncarTexto && !isTextoTruncado">(Ver menos)</span>
            </p>
        </div>

        <div class="text-center">
            <img
                v-bind:src="imagen"
                class="img-fluid"
                v-if="imagen"
                :class="{ maxHeight450: showPostPage }"
            />
        </div>
        <div class="row g-0 mx-2 text-muted my-2" style="font-size:14px" v-show="likeInfo.count || cantidadComentariosDisplay">
            <div class="col" data-bs-toggle="modal" v-bind:data-bs-target="'#likesPost' + postId" role="button" >
                <span v-if="likeInfo.count">
                    <svg xmlns="http://www.w3.org/2000/svg"
                    width="15"
                    height="12"
                    preserveAspectRatio="none"
                    fill="currentColor"
                    viewBox="0 0 16 16">
                        <path d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2.144 2.144 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a9.84 9.84 0 0 0-.443.05 9.365 9.365 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111L8.864.046zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a8.908 8.908 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.224 2.224 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.866.866 0 0 1-.121.416c-.165.288-.503.56-1.066.56z"/>
                    </svg>
                    {{likeInfo.count}} Personas
                </span>
            </div>
            <div class="col col-auto text-end">
                <span v-if="cantidadComentariosDisplay">
                    <svg xmlns="http://www.w3.org/2000/svg"
                    width="15"
                    height="12"
                    fill="currentColor"
                    viewBox="0 0 16 16">
                        <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                    </svg>
                    {{cantidadComentariosDisplay}} comentarios
                </span>
            </div>
        </div>
        <hr class="my-0" />
        <div
            class="row text-secondary g-0 fw-bold"
            role="button"
            style="user-select: none;font-size:14px;"
        >
            <div class="col text-center py-2" v-wave @click="toggleLike" :class="{like: likeInfo.miLike}">
                <svg xmlns="http://www.w3.org/2000/svg"
                v-if="likeInfo.miLike"
                width="25"
                height="20"
                preserveAspectRatio="none"
                fill="currentColor"
                viewBox="0 0 16 16">
                    <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg"
                v-else
                width="25"
                height="20"
                preserveAspectRatio="none"
                fill="currentColor"
                viewBox="0 0 16 16">
                    <path d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2.144 2.144 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a9.84 9.84 0 0 0-.443.05 9.365 9.365 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111L8.864.046zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a8.908 8.908 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.224 2.224 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.866.866 0 0 1-.121.416c-.165.288-.503.56-1.066.56z"/>
                </svg>
                Me gusta
            </div>
            <div class="col text-center py-2" v-wave @click="focusCajaTexto">
                <svg xmlns="http://www.w3.org/2000/svg"
                width="30"
                height="20"
                fill="currentColor"
                viewBox="0 0 16 16">
                    <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                </svg>
                Comentar
            </div>
        </div>
        <hr class="my-0" />
        <seccion-comentarios-component
            @contador-actualizado="actualizarContador"
        ></seccion-comentarios-component>
    </div>
</template>

<script>
import SeccionComentariosComponent from "./SeccionComentariosComponent.vue";

export default {
    components: {
        SeccionComentariosComponent,
    },
    data() {
        return {
            fontSize: 14,
            likeInfo:{
                miLike: false,
                count:0
            },
            likes: [],
            fechaCreacionDisplay: '',
            cantidadComentariosDisplay: 0,
            textoTruncado: '',
            isTextoTruncado: true,
            truncarTexto: false,
        };
    },
    props: [
        "postId",
        "usuarioNombre",
        "usuarioImagen",
        "imagen",
        "descripcion",
        "showPostPage",
        "fechaCreacion",
        "usuarioUrl",
    ],
    provide(){
        return {
            postId : this.postId
        };
    },
    inject: [
        "usuarioLoginId",
    ],
    mounted() {
        this.calcularTruncamiento();

        var thisComponent = this;
        setTimeout(function(){
            thisComponent.$refs.card.classList.add("cardPostVisible");
        }, Math.random() * 500);
        if (!this.showPostPage) {
            new ResizeObserver(function () {
                var msnry = new Masonry(".masonry-row", {
                    percentPosition: true,
                });
            }).observe(this.$refs.card);
        }
        //calcular nuevo tamaño del texto de la publicacion
        if (!this.imagen && this.descripcion) {
            var l = this.descripcion.length;
            if (l < 100) {
                this.fontSize = 26;
            } else if (l < 200) {
                this.fontSize = 22;
            } else if (l < 250) {
                this.fontSize = 18;
            }
        }

        if(this.usuarioLoginId){
            this.obtenerMiLike();
        }
        var thisComponent = this;
        var myModalEl = document.getElementById('likesPost' + this.postId)
        myModalEl.addEventListener('shown.bs.modal', function (event) {
            thisComponent.obtenerLikes();
        });
        this.establecerFechaCreacionDisplay();

    },
    computed: {
        mostrarDescripcion(){
            return (this.truncarTexto && this.isTextoTruncado) ? this.textoTruncado : this.descripcion;
        }
    },
    methods: {
        calcularTruncamiento(){
            if(!this.descripcion){
                return;
            }
            let tamanoLineas = 40;
            let maxLineas = 5;
            let contadorLineas = 0;
            let index = 0;
            let lineas = this.descripcion.split("\n");
            for(let i = 0 ; i< lineas.length ; i++){
                let partLineas = Math.ceil(lineas[i].length / tamanoLineas);
                if(contadorLineas + partLineas > maxLineas){
                    this.textoTruncado = this.descripcion.substring(0, index + ((maxLineas - contadorLineas) * tamanoLineas)).trim() + "...";
                    this.truncarTexto = true;
                    return;
                }
                contadorLineas += partLineas;
                index += lineas[i].length;
                if(i > 0){
                    index += 1;
                }
            }
        },
        focusCajaTexto() {
            console.log("cajaTexto" + this.postId);
            document.querySelector("#cajaTexto" + this.postId).focus();
        },
        eliminarPublicacion(){

            axios.post("/posts/" + this.postId, {
                _method: "DELETE"
            })
            .then(response=>{
                console.log(response.data);
                location.replace("/");
            })
            .catch(response=>{
                console.log(response);
            });
        },
        toggleLike(){
            console.log("like!" + this.postId);
            axios.post(`/posts/${this.postId}/likes`, {
            })
            .then(response=>{
                this.likeInfo = response.data;
                console.log(response.data);
            })
            .catch(response=>{
                console.log(response.data);
            });
        },
        obtenerMiLike(){
            axios.get(`/posts/${this.postId}/likes/${this.usuarioLoginId}`)
            .then(response=>{
                this.likeInfo = response.data;
            })
            .catch(response=>{
                console.log(response.data);
            })
        },
        obtenerLikes(){
            axios.get(`/posts/${this.postId}/likes`)
            .then(response=>{
                console.log(response.data);
                this.likes = response.data.data;
            })
            .catch(response=>{
                console.log(response.data);
            });
        },
        establecerFechaCreacionDisplay(){
            var ahora = Date.now();
            var diferencia = (ahora/ 1000) - this.fechaCreacion;
            if(diferencia < 60){
                this.fechaCreacionDisplay = "Hace un momento";
            }else if(diferencia < 60 * 60){
                var m = Math.trunc(diferencia / 60);
                this.fechaCreacionDisplay = `Hace ${m} minutos`;
            }else if(diferencia < 60 * 60 * 24){
                var h = Math.trunc(diferencia / 60 / 60);
                this.fechaCreacionDisplay = `Hace ${h} horas`;
            }else if (diferencia < 60 * 60 * 24 * 4){
                var d = Math.trunc(diferencia / 60 / 60 / 24);
                this.fechaCreacionDisplay = `Hace ${d} días`;
            }else{
                var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                var fecha = new Date(this.fechaCreacion * 1000);
                var d = fecha.getDate();
                var m = meses[fecha.getMonth()];
                var h = fecha.getHours();
                var mm = fecha.getMinutes();
                this.fechaCreacionDisplay = ` ${d} de ${m} a las ${h}:${mm < 10 ? '0' + mm : mm}`;
            }
        },
        actualizarContador(count){
            this.cantidadComentariosDisplay = count;
        }
    },
};
</script>
<style scoped>
.imagenUsuario {
    border-radius: 50%;
    height: 35px;
}
.maxHeight450 {
    max-height: 450px;
}
.fontSize15 {
    font-size: 15px;
}
.imgPequeno {
    height: 35px;
    width: 35px;
}
.imgGrande {
    height: 45px;
    width: 45px;
}
.like{
    color: #0571ED;
}
.cardPostInvisible{
    opacity: 0;
}
.cardPostVisible{
    opacity: 1;
}
.card{
    transition: opacity 0.6s ease-out;
}
</style>
