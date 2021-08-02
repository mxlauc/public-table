<template>
    <li class="nav-item dropdown guide-7" @click="showGuide=true">
        <a href="#" class="nav-link active">
            {{__('Show guide')}}
        </a>
    </li>
    <v-simple-guided-tour
        color="#00A2FF"
        :labels="labels"
        :steps="steps"
        @closed="dialogClosed"
        :show="showGuide">
    </v-simple-guided-tour>
</template>
<script>
import VSimpleGuidedTour from 'v-simple-guided-tour';
export default {
    components : {
        VSimpleGuidedTour,
    },
    data(){
        return {
            showGuide: false,
            labels : {
                prev : this.__("Previous"),
                next : this.__("Next"),
                close : this.__("Close")
            },
            steps : [
                {
                    selector: ".guide-1",
                    title: this.__('Welcome to Public Table'),
                    description: this.__("By clicking here you will go to the main page")
                },
                {
                    selector: ".guide-2",
                    title: this.__("Change language"),
                    description: this.__("You can choose your default language here")
                },
                {
                    selector: ".guide-3",
                    title: this.__('Like'),
                    description: this.__("You can indicate that a publication you like with this button")
                },
                {
                    selector: ".guide-4",
                    title: this.__("Comment"),
                    description: this.__("You can comment on text or a gif")
                },
                {
                    selector: ".guide-5",
                    title: this.__("My profile"),
                    description: this.__("You can access your profile or log out")
                },
                {
                    selector: ".guide-6",
                    title: this.__("Notifications"),
                    description: this.__("We will inform you if someone interacts with your publications")
                },
                {
                    selector: ".guide-7",
                    title: this.__("Show guide"),
                    description: this.__("That's it! You can see the guide again")
                }
            ]
        }
    },
    methods:{
        dialogClosed(){
            this.showGuide = false;
        }
    },
}
</script>
<style scoped>

</style>
