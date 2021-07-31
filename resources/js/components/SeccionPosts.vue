<template>
    <v-simple-infinite-scroll @load="cargarMasPosts" :distance="0">
        <template #default>
            <div class="row masonry-row justify-content-center">
                <div class="col" :class="[classItem]"  v-for="post in posts" v-bind:key="post.id">
                    <post-component
                        :post="post"
                        :show-post-page="false">
                    </post-component>
                </div>
                <div class="v-simple-infinite-scroll-bottom col" :class="[classItem]">
                </div>
            </div>
        </template>
        <template #carganido>Cargando...</template>
    </v-simple-infinite-scroll>

</template>
<script>
import VSimpleInfiniteScroll from 'v-simple-infinite-scroll';
import PostComponent from './PostComponent.vue';
export default {
    components: {
        VSimpleInfiniteScroll,
        PostComponent,
    },
    data(){
        return {
            posts: [],
            postsPaginador: null
        };
    },
    props:{
        classItem : {
            type : String,
            default : 'col-12 col-md-6 col-lg-4 col-xl-3',
        },
        url : {
            type : String,
            default : '/posts',
        }
    },
    mounted(){

    },
    methods: {
        cargarMasPosts(scroller){
            let url = this.postsPaginador ? this.postsPaginador.next : this.url;
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
