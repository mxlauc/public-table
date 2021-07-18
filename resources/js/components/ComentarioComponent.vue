<template>
    <div class="row g-0">
        <div class="col col-auto py-1 ps-2">
            <img v-bind:src="comentario.user.avatar" class="imagenUsuario" />
        </div>
        <div class="col ps-2 pt-1 pb-1">
            <span class="textarea text-break" style="font-size: 12px">
                <label class="fw-bold">
                    {{ comentario.user.name }}
                </label>
                <p class="m-0">
                    {{ comentario.descripcion }}
                </p>
                <div class="position-relative" v-if="comentario.gif_url">
                    <img :src="comentario.gif_url" class="img-fluid rounded">
                    <span
                        class="px-1 rounded position-absolute bottom-0 start-0 m-1"
                        style="background-color:rgba(255,255,255,0.4);">
                        <img src="https://www.gstatic.com/tenor/web/attribution/via_tenor_logo_grey.png"
                            style="filter: drop-shadow(1px 1px 2px rgba(255, 255, 255, 1));"
                            width="50">
                    </span>
                </div>
            </span>
        </div>
        <div class="col col-auto">
            <svg xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                class="py-3 px-2"
                style="width: 32px; color:#888;"
                viewBox="0 0 16 16"
                data-bs-toggle="dropdown"
                aria-expanded="false">
            <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
            </svg>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li>
                    <button class="dropdown-item" type="button"
                        data-bs-toggle="modal"
                        v-bind:data-bs-target="'#editarComentarioModal' + postId"
                        v-bind:data-bs-id-comentario="comentario.id">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                        </svg>
                        Editar comentario
                    </button>
                </li>
                <li>
                    <button
                        class="dropdown-item"
                        type="button"
                        data-bs-toggle="modal"
                        v-bind:data-bs-target="'#eliminarComentarioModal' + postId"
                        v-bind:data-bs-id-comentario="comentario.id">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                        </svg>
                        Eliminar comentario
                    </button>
                </li>
            </ul>


        </div>
    </div>
</template>

<script>
export default {
    props: ["comentario"],
    inject: ["postId"]
};
</script>

<style scoped>
.imagenUsuario {
    border-radius: 50%;
    height: 30px;
}

.textarea {
    white-space: pre-wrap;
    background-color: #eee;
    border-radius: 12px;
    padding: 5px 10px;
    display: block;
    font-size: 14px;
}
</style>

