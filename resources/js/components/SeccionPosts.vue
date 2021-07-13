<template>
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
    <button class="btn btn-primary w-100" @click="cargarMasPosts">Cargar mas</button>
</template>
<script>
export default {
    data(){
        return {
            posts: [],
            postsPaginador: null
        };
    },
    mounted(){
        this.cargarPosts();
    },
    methods: {
        cargarPosts(){
            axios.get('/posts')
            .then(response=>{
                console.log(response.data);
                this.postsPaginador = response.data;
                this.posts = response.data.data;
            })
            .catch(response=>{
                console.log(response.data);
            })
        },
        cargarMasPosts(){
            if(this.postsPaginador.next_page_url){
                axios.get(this.postsPaginador.next_page_url)
                .then(response=>{
                    console.log(response.data);
                    this.postsPaginador = response.data;
                    this.posts = this.posts.concat(response.data.data);
                })
                .catch(response=>{
                    console.log(response.data);
                });
            }
        }
    }
}
</script>
<style scoped>

</style>
