<template>
<!-- Modal Editar comentario -->
        <div
            class="modal fade"
            id="editarNombreUsuarioModal"
            tabindex="-1"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{__('Edit name of user')}}</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <p>
                            {{__('Write a name of user')}}
                        </p>
                        <div class="contenedorInput">
                            <form action="" method="POST" ref="formUserName" @submit.prevent="actualizarNombreUsuario">
                                <span>public-table.com/@</span>
                                <input type="text" name="user_name" placeholder="carlos.45 (ejemplo)" :value="user?.user_name" ref="usuarioNombreInput">
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                            {{__('Cancel')}}
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="actualizarNombreUsuario">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                            </svg>
                            {{__('Save')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
<div style="
    position: relative;
    overflow: hidden;
    width: 100%;
    height: 450px;
    ">
    <img
        :src="user?.avatar"
        style="
        position: absolute;
        object-fit: cover;
        left: -50px;
        top: -50px;
        width: calc(100% + 100px);
        height: 550px;
        filter: blur(40px);
        ">
    <div style="position: relative; height: 450px; background-color: rgba(0, 0, 0, 0.3)">
        <div class="container text-white text-center p-5" style="font-family: 'Secular One', sans-serif; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);">
            <img :src="user?.avatar" class="rounded-circle" style="height: 100px; border: 4px solid white">
            <h2>{{user?.name}}</h2>
            <div v-if="user?.user_name">
                <a :href="user?.url" class="text-decoration-none text-white">@{{user?.user_name}}</a>
            </div>

            <div class="mt-2">
                <button
                    type="button"
                    class="btn btn-sm btn-outline-light"
                    data-bs-toggle="modal"
                    data-bs-target="#editarNombreUsuarioModal"
                    v-if="usuarioLogin?.id == usuarioId">
                    {{user?.user_name ? __('Edit name of user') : __('Create a name of user')}}
                </button>
                <div v-else-if="usuarioLogin">
                    <button type="button" class="btn btn-sm btn-outline-light" v-if="userData?.following" @click="toggleSeguir">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg>
                        {{__('Following')}}
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-light" v-else @click="toggleSeguir">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                        {{__('Follow')}}
                    </button>
                </div>

            </div>

            <div class="row justify-content-center mt-3">
                <div class="col col-auto">
                    <div class="row gx-5">
                        <div class="col col-12 col-sm-4" style="min-width: 33%">
                            <h3>{{userData?.posts}}</h3>
                            <h6>{{__('Publications')}}</h6>
                        </div>
                        <div class="col col-6 col-sm-4" style="min-width: 33%">
                            <h3>{{userData?.followers}}</h3>
                            <h6>{{__('Followers')}}</h6>
                        </div>
                        <div class="col col-6 col-sm-4" style="min-width: 33%">
                            <h3>{{userData?.followeds}}</h3>
                            <h6>{{__('Following')}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return {
            user : null,
            userData : null,
        }
    },
    props: ["usuarioId"],
    inject: ["usuarioLogin"],
    mounted(){
        this.cargarUsuario();
        this.consultarSiguiendo();
    },
    methods :{
        cargarUsuario(){
            axios.get('/users/' + this.usuarioId)
            .then(response=>{
                this.user = response.data.data;
            })
            .catch(response=>{
                console.log(response);
            });
        },
        actualizarNombreUsuario(){
            var formData = new FormData(this.$refs.formUserName);
            formData.append('_method', 'PUT');
            axios.post('/users/' + this.usuarioId, formData)
            .then(response=>{
                var modalHTML = document.getElementById("editarNombreUsuarioModal");
                var myModal = window.bootstrap.Modal.getInstance(modalHTML);
                myModal.hide();
                this.user = response.data.data;
            })
            .catch(response=>{
                console.log(response);
            })
        },
        consultarSiguiendo(){
            axios.get('/followers/' + this.usuarioId)
            .then(response=>{
                this.userData = response.data;
                console.log(response.data);
            })
            .catch(response=>{
                console.log(response);
            });
        },
        toggleSeguir(){
            axios.post('/followers/' + this.usuarioId)
            .then(response=>{
                this.userData = response.data;
                console.log(response.data);
            })
            .catch(response=>{
                console.log(response);
            });
        }
    }
}
</script>
<style scoped>
.contenedorInput{
    background-color: #eee;
    padding: 5px 10px;
    border-radius: 10px;
}
.contenedorInput > input{
    background-color: transparent;
    border: none;
    outline: none;
}
</style>
