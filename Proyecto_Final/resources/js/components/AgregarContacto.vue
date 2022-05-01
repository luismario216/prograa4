<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{titulo}}</div>
                <div class="card-body text-center">
                    <form ref="contactoForm" @submit.prevent="addContacto" class="form-group">
                        <div class="col-md-12">
                            <label class="col-md-4 text-md-end">{{buscar}}</label>
                            <div class="row mb-12">
                                <v-select :options="usuarios" v-model="selectedUser" label="label" placeholder="Select a user"></v-select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary">
                                    {{agregar}}
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
    import vSelect from 'vue-select'
    import 'vue-select/dist/vue-select.css'
    export default {
        props: ['titulo', 'agregar', 'buscar'],
        data() {
            return {
                buscar_por: 'nombre',
                filtros: [
                    { name: 'Nombre', value: 'nombre' },
                    { name: 'Numero', value: 'numero' },
                ],
                usuarios: [],
                selectedUser: null,
            }
        },
        methods: {
            conseguirUsuarios() {
                axios.get('/usuarios').then(response => {
                    this.usuarios = response.data;
                    this.usuarios.forEach(user => {
                        user.label = user.name + ' ' + (user.last_name || '') + '-' + user.number;
                    });
                }).catch(error => {
                    console.log(error);
                });
            },
            addContacto() {
                axios.post('/contactos', {
                    contact_id: this.selectedUser.id,
                }).then(response => {
                    console.log(response);
                }).catch(error => {
                    console.log(error);
                });
            },
        },
        components: {
            'v-select': vSelect
        },
        mounted() {
            this.conseguirUsuarios();
        }
    }
</script>
