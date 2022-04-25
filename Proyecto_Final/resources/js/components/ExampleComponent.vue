<template>
    <div class="row justify-content-center">
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
        </div>
    </div>
</template>

<script>
    export default {
        props: ['titulo', 'guardar'],
        data() {
            return {
                langs: {
                    es: 'Español',
                    en: 'English'
                },
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
        },
        mounted() {
            console.log(this.titulo, this.guardar);
        }
    }
</script>
