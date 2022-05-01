<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{titulo}}</div>
                <div class="card-body text-center">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">{{nombre}}</th>
                                <th scope="col">{{apellido}}</th>
                                <th scope="col">{{numero}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="contacto, index in contactos" :key="index">
                                <td>{{contacto.name}}</td>
                                <td>{{contacto.last_name}}</td>
                                <td>{{contacto.number}}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['titulo', 'nombre', 'apellido', 'numero'],
        data() {
            return {
                contactos: [],
            }
        },
        methods: {
            conseguirUsuarios() {
                axios.get('/contactos').then(response => {
                    this.contactos = response.data;
                }).catch(error => {
                    console.log(error);
                });
            },
        },
        mounted() {
            this.conseguirUsuarios();
        }
    }
</script>