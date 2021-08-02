<template>
 <v-simple-infinite-scroll
    @load="getLikes"
    :load-to-fill="false"
    :distance="50">
    <like-item-component
        v-for="like in likes"
        v-bind:key="like.id"
        :like="like">
    </like-item-component>
 </v-simple-infinite-scroll>
</template>
<script>
import VSimpleInfiniteScroll from 'v-simple-infinite-scroll';
import LikeItemComponent from './LikeItemComponent.vue';

export default {
    components : {
        VSimpleInfiniteScroll,
        LikeItemComponent,
    },
    data(){
        return {
            likes : [],
            next : this.url,
        }
    },
    props: [
        "url"
    ],
    methods:{
        getLikes(scroll){
            axios.get(this.next)
            .then(response=>{
                this.likes = this.likes.concat(response.data.data);
                this.next = response.data.links.next;
                if(this.next){
                    scroll.loaded();
                }else{
                    scroll.complete();
                }
            })
            .catch(response=>{
                console.log(response.data);
            });
        }
    },
}
</script>
