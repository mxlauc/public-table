<template>
    <div class="contenedor mx-2 p-2 position-relative">
        <a :href="url" class="text-decoration-none">
            <div class="row g-0">
                <div class="col col-auto">
                    <img :src="imagen" class="rounded-circle me-3" style="height:50px">
                </div>
                <div class="col">
                    <span v-html="descripcion"  :class="{'text-dark' : !visto, 'text-muted' : visto}">
                    </span>
                    <span :class="{'text-primary': !visto, 'text-dark' : visto}" class="d-block" style="font-size:12px">{{timestampDisplay}}</span>
                </div>
            </div>
        </a>
        <div class="dropdown dropstart position-absolute" style="right:20px; top: calc(50% - 20px);">
            <div class="opciones rounded-circle shadow-sm ms-auto" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg"
                width="40"
                    fill="currentColor"
                    class="py-2 px-2"
                    style="color:#888;"
                    viewBox="0 0 16 16">
                <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                </svg>
            </div>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li class="dropdown-item" role="button" @click="toggleReadAt">{{visto ? __('Mark as unread') : __('Mark as read')}}</li>
                <li class="dropdown-item" role="button" @click="eliminarNotificacion">{{__('Delete')}}</li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {

        }
    },
    props: [
        "id",
        "imagen",
        "url",
        "descripcion",
        "timestamp",
        "visto"
    ],
    emits: [
        "deleted",
        "updated"
    ],
    computed: {
        timestampDisplay(){
            return this.timeAgo(this.timestamp);
        }
    },
    methods: {
        eliminarNotificacion(){
            axios.delete('/notificaciones/' + this.id)
            .then(response => {
                console.log(response.data);
                this.$emit("deleted", response.data.id, response.data.unread);

            });
        },
        toggleReadAt(){
            console.log("xdxd");
            axios.put('/notificaciones/' + this.id)
            .then(response => {
                console.log(response.data);
                this.$emit("updated", response.data.id, response.data.unread, response.data.readed);
            });
        }
    },
}
</script>
<style scoped>
    .contenedor{
        border-radius:10px;
    }
    .contenedor:hover{
        background-color:#eee;
    }
    .opciones{
        visibility: hidden;
        height: 40px;
        width: 40px;
        background-color: #fff;
    }
    .opciones:hover{
        background-color: #f5f5f5;
    }
    .contenedor:hover .opciones{
        visibility: visible;
    }
</style>
