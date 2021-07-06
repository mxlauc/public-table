<template>
  <div class="card mb-4" style="box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1)">
    <div class="card-body">
      <div class="row g-0">
        <div class="col col-2">
          <img v-if="usuarioImagen"
            v-bind:src="usuarioImagen"
            class="rounded-circle"
            width="35"
            height="35"
          />
        </div>
        <div class="col col-9">
          <p class="fw-bold m-0 p-0" style="font-size:11px">{{ usuarioNombre }}</p>
          <p class="text-muted m-0 p-0" style="font-size: 10px;">Hace 12 horas</p>
        </div>
        <div class="col col-1 text-end">
          <img
            src="https://www.pikpng.com/pngl/m/517-5179322_3-black-dots-icon-3-points-icon-png.png"
            style="width: 16px"
          />
        </div>
      </div>
      <hr class="my-2" />
      <p class="card-text" style="font-size: 14px">
        {{ descripcion }}
      </p>
    </div>
    <img v-bind:src="imagen" class="card-img-bottom" v-if="imagen">
    <hr class="my-0" v-if="!imagen">
    <div class="row text-secondary">
      <div class="col text-center py-2">Reccionar</div>
      <div class="col text-center py-2">Comentar</div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["usuarioNombre", "usuarioImagen", "imagen", "descripcion"],
  mounted() {

  },
};
</script>

