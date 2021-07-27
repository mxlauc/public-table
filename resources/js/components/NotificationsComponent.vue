<template>
    <a class="nav-link active dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
        Notificaciones
        <div class="d-inline-block position-relative me-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z"/>
            </svg>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" v-if="total">
                {{total}}
                <span class="visually-hidden">
                    unread messages
                </span>
            </span>
        </div>

    </a>
    <div class="dropdown-menu dropdown-menu-end shadow-lg" style="min-width:400px;min-helight:500px;max-height:80vh;overflow-y:auto;overflow-x:hidden;">
        <notification-component v-for="notificacion in notificaciones" :key="notificacion"
            :id="notificacion.id"
            :imagen="notificacion.imagen"
            :descripcion="notificacion.descripcion"
            :visto="notificacion.visto"
            :timestamp="notificacion.timestamp"
            :url="notificacion.url"
            @deleted="onDeleted"
            @updated="onUpdated">
        </notification-component>
        <button @click="getNotifications" v-if="notificacionesPaginador?.next">cargar mas</button>
    </div>
</template>
<script>
import NotificationComponent from './NotificationComponent.vue';
import VSimpleInfiniteScroll from 'v-simple-infinite-scroll';

export default {
    components: {
        NotificationComponent,
        VSimpleInfiniteScroll,
    },
    data(){
        return {
            total: 0,
            notificaciones: [],
            notificacionesPaginador : null,
        }
    },
    mounted(){
        this.getNotifications();
    },
    methods: {
        getNotifications(){
            let url = this.notificacionesPaginador ? this.notificacionesPaginador.next : "/misNotificaciones";
            console.log(url);
            if(url){
                axios.get(url)
                .then(response=>{
                    this.notificaciones = this.notificaciones.concat(response.data.data);
                    this.notificacionesPaginador = response.data.links;

                    this.total = response.data.meta.unread;
                    console.log(response.data);
                });
            }
        },
        onDeleted(id, unread){
            var indice = this.notificaciones.findIndex(
                (notificacion) =>
                    notificacion.id == id
            );
            this.notificaciones.splice(indice, 1);
            this.total = unread;
        },
        onUpdated(id, unread, readed){
            this.total = unread;
            var indice = this.notificaciones.findIndex(
                (notificacion) =>
                    notificacion.id == id
            );
            this.notificaciones[indice].visto = readed;
        }
    },
}
</script>
<style scoped>

</style>
