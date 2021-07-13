<template>
    <div>
        <div class="row justify-content-center">
            <div class="col col-8">
                <label
                    class="form-control text-muted mb-4"
                    role="button"
                    tabindex="0"
                    data-bs-toggle="modal"
                    data-bs-target="#crearPublicacionModal"
                >
                    Publicar algo...
                </label>
            </div>
        </div>

        <!-- Modal -->
        <div
            class="modal fade"
            id="crearPublicacionModal"
            tabindex="-1"
            data-bs-backdrop="static"
            data-bs-keyboard="false"
            aria-hidden="true"
        >
            <div
                class="
                    modal-dialog modal-dialog-centered modal-dialog-scrollable
                "
            >
                <div
                    class="modal-content"
                    style="box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1)"
                >
                    <div class="modal-header">
                        <h5 class="modal-title">Crear publicación</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div class="mb-2">
                                <label>
                                    <img
                                        v-bind:src="usuarioLoginImagen"
                                        class="rounded-circle"
                                        style="height: 40px"
                                    />
                                    {{ usuarioLoginNombre }}
                                </label>
                            </div>
                            <form
                                action="/"
                                @submit.prevent="enviarFormulario"
                                ref="formCrear"
                                method="POST"
                            >
                                <textarea
                                    name="descripcion"
                                    style="
                                        width: 100%;
                                        height: 100px;
                                        resize: none;
                                        border: 0px;
                                        outline: none;
                                    "
                                    placeholder="¿En qué estas pensando?"
                                ></textarea>
                                <input
                                    type="file"
                                    name="imagen"
                                    id="imagen"
                                    class="d-none"
                                    @change="mostrarPreview"
                                />
                            </form>

                            <img
                                v-bind:src="imagenPreview"
                                class="w-100"
                                v-if="imagenPreview"
                            />

                            <label
                                for="imagen"
                                class="form-control"
                                tabindex="0"
                                role="button"
                                v-else
                            >
                                <img
                                    src="https://img.icons8.com/cotton/2x/image-file-add--v2.png"
                                    style="height: 20px"
                                />
                                Agregar imagen
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-primary w-100 mt-2"
                            @click="enviarFormulario"
                        >
                            Publicar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    inject: ["usuarioLoginImagen", "usuarioLoginNombre"],
    data() {
        return {
            imagenPreview: null,
        };
    },
    methods: {
        enviarFormulario(e) {
            e.preventDefault();

            var formData = new FormData(this.$refs.formCrear);

            /* AJAX request */
            axios({
                method: "post",
                url: "/posts",

                data: formData,

                config: {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                },
            })
                /* handle success */
                .then((response) => {
                    this.ocultarModal();
                })

                /* handle error */
                .catch((response) => {
                    console.log(response);
                });
        },
        ocultarModal() {
            var modalHTML = document.getElementById("crearPublicacionModal");
            var myModal = window.bootstrap.Modal.getInstance(modalHTML);
            let formulario = this.$refs.formCrear;
            modalHTML.addEventListener("hidden.bs.modal", function (event) {
                this.imagenPreview = null;
                formulario.reset();
            });
            myModal.hide();
        },
        mostrarPreview(e) {
            this.imagenPreview = URL.createObjectURL(e.target.files[0]);
        },
    },
};
</script>
<style scoped>
</style>
