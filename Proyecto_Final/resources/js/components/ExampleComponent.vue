<template>
    <div class="col-md-7 justify-content-center toast-notification" style="position: absolute;right: 0px;z-index: 10;top: 80px;">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ titulo }}</div>
                <div class="card-body">
                    <form @submit="changeLanguaje" ref="lanForm">
                        <div class="col-md-8">
                            <div v-for="lan, index in langs" class="row mb-3" :key="index">
                                <label class="col-md-4 col-form-label text-md-end" :key="index" :for="index">{{ lan }}</label>
                                <div class="col-md-6 text-center align-self-center">
                                    <input type="radio" :value="index" name="languaje" :id="index">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary">
                                    {{ guardar }}
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="card" v-if="login == 1">
                <div class="card-header">
                    {{ mensajes[lang]['changeName'] }}
                </div>
                <div class="card-body">
                    <form @submit.prevent="changeName" ref="nameForm">
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end" :for="name">{{ mensajes[lang]['newName'] }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" :id="name" :name="name" v-model="name">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary">
                                    {{ mensajes[lang]['changeName'] }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card" v-if="login == 1">
                <div class="card-header">
                    {{ mensajes[lang]['deleteAccount'] }}
                </div>
                <div class="card-body">
                    <form @submit.prevent="deleteAccount" ref="deleteForm">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary">
                                    {{ mensajes[lang]['deleteAccount'] }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            titulo: {
                type: String,
                default: 'Languaje'
            },
            guardar: {
                type: String,
                default: 'Guardar'
            },
            lang: {
                type: String,
                default: 'es'
            },
            login: {
                type: Number,
                default: null
            },
        },
        data() {
            return {
                langs: {
                    es: 'Español',
                    en: 'English'
                },
                name: '',
                mensajes: {
                    en: {
                        changeName: 'Change name',
                        deleteAccount: 'Delete account',
                        changeLanguaje: 'Change languaje',
                        newName: 'New name'
                    },
                    es: {
                        changeName: 'Cambiar nombre',
                        deleteAccount: 'Eliminar cuenta',
                        changeLanguaje: 'Cambiar idioma',
                        newName: 'Nuevo nombre'
                    }
                }
            }
        },
        methods: {
            changeLanguaje() {
                this.languaje = this.$refs.lanForm.languaje.value;
                axios.get('/locale/' + this.languaje).then(response => {
                    console.log(response);
                }).catch(error => {
                    console.log(error);
                });
            },
            changeName() {
                axios.post('/new-name', {name: this.name}).then(response => {
                    console.log(response);
                    location.reload();
                }).catch(error => {
                    console.log(error);
                });
            },
            deleteAccount() {
                axios.delete('/delete').then(response => {
                    console.log(response);
                    location.reload();
                }).catch(error => {
                    console.log(error);
                });
            }
        },
        mounted() {
            console.log(this.titulo, this.guardar, this.lang, this.login);
        }
    }
</script>
