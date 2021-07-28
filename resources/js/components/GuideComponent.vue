<template>
    <li class="nav-item dropdown" @click="showGuide=true">
        <a href="#" class="nav-link active">
            Ver guía
        </a>
    </li>
    <v-simple-guided-tour
        color="#00A2FF"
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
            steps : [
                {
                    selector: ".navbar-brand",
                    title: "Bienvenido a Public Table",
                    description: "Este es un lugar donde puedes compartir contenido públicamente"
                },
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
