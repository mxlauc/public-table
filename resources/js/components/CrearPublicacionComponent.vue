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
                    {{__('Post something')}}...
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
                        <h5 class="modal-title">{{__('Create post')}}</h5>
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
                                        v-bind:src="usuarioLogin?.avatar"
                                        class="rounded-circle"
                                        style="height: 40px"
                                    />
                                    {{ usuarioLogin?.nombre }}
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
                                    ref="textarea"
                                    @keyup="keyup"
                                    :placeholder="__('What are you thinking about?')"
                                ></textarea>
                                <input
                                    type="file"
                                    name="imagen"
                                    id="imagen"
                                    class="d-none"
                                    accept="image/png, image/jpeg"
                                    @change="mostrarPreview"
                                />
                            </form>

                            <div class="position-relative" v-if="imagenPreview">
                                <img
                                v-bind:src="imagenPreview"
                                class="w-100 rounded-3">
                                <button
                                    type="button"
                                    class="btn-close bg-white shadow position-absolute top-0 end-0 m-3 p-2 rounded-circle"
                                    aria-label="Close"
                                    @click="borrarImagen">
                                </button>
                            </div>

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
                                {{__('Add image')}}
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-primary w-100 mt-2"
                            :disabled="disableButton"
                            @click="enviarFormulario"
                        >
                            {{__('Publish')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    inject: ["usuarioLogin"],
    data() {
        return {
            imagenPreview: null,
            textareaLength: 0,
        };
    },
    computed:{
        disableButton(){
            return !this.imagenPreview && !this.textareaLength;
        }
    },
    emits: ["postCreated"],
    methods: {
        keyup(e){
            this.textareaLength = this.$refs.textarea.value.trim().length;
        },
        enviarFormulario(e) {
            e.preventDefault();

            var formData = new FormData(this.$refs.formCrear);
            axios.post('/posts', formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            })
            .then((response) => {
                console.log(response.data.data);
                this.$emit("postCreated", response.data.data);
                this.ocultarModal();
            })
            .catch((error) => {
                let indices = Object.keys(error.response.data.errors);
                if(indices.length > 0){
                    alert(error.response.data.errors[indices[0]]);
                }
            });
        },
        ocultarModal() {
            var myModal = window.bootstrap.Modal.getInstance(document.getElementById("crearPublicacionModal"));
            myModal.hide();
            this.imagenPreview = null;
            this.$refs.formCrear.reset();
        },
        mostrarPreview(e) {
            this.imagenPreview = URL.createObjectURL(e.target.files[0]);
        },
        borrarImagen(){
            this.$refs.formCrear.imagen.value = ''
            this.imagenPreview = null;
        },
    },
};
</script>
<style scoped>
</style>
