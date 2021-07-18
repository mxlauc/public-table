<template>
    <v-simple-infinite-scroll @cargar="cargarMasPosts" :distance="250">
        <template #default>
            <div class="row masonry-row justify-content-center">
                <div class="col col-12 col-md-6 col-lg-4 col-xl-3" v-for="post in posts" v-bind:key="post.id">
                    <post-component
                        :post-id="post.id"
                        :usuario-nombre="post.user.name"
                        :usuario-imagen="post.user.avatar"
                        :imagen="post.imagen"
                        :descripcion="post.descripcion"
                        :fecha-creacion="post.created_at"
                        :show-post-page="false">
                    </post-component>
                </div>
            </div>
        </template>
        <template #carganido>Cargando...</template>
    </v-simple-infinite-scroll>

</template>
<script>
import VSimpleInfiniteScroll from 'v-simple-infinite-scroll';
export default {
    components: {
        VSimpleInfiniteScroll,
    },
    data(){
        return {
            posts: [],
            postsPaginador: null
        };
    },
    mounted(){

    },
    methods: {
        cargarMasPosts(scroller){
            let url = this.postsPaginador ? this.postsPaginador.next : '/posts';
            if(url){
                axios.get(url)
                .then(response=>{
                    this.postsPaginador = response.data.links;
                    this.posts = this.posts.concat(response.data.data);
                    scroller.loaded();
                })
                .catch(response=>{
                    console.log(response.data);
                });
            }
        },
    }
}
</script>
<style scoped>

</style>
