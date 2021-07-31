<template>
<a :href="like.user.url" class="usuarioItem text-decoration-none d-block">
    <div class="row g-0">
        <div class="col col-auto py-1 ps-2">
            <img v-bind:src="like.user.avatar" class="imagenUsuario" />
        </div>
        <div class="col ps-2 pt-2 pb-1">
            <span style="font-size:16px;" class=" fw-bold text-dark">{{like.user.name}}</span>
        </div>
    </div>
</a>
</template>
<script>
export default {
    props: [
        "like"
    ]
}
</script>
<style scoped>
.usuarioItem{
    border-radius: 10px;
}
.usuarioItem:hover{
    background-color: #eee;
}
.imagenUsuario {
    border-radius: 50%;
    height: 35px;
}
</style>
