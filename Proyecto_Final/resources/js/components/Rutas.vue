<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 text-left">
                            <h4>{{titulo}}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body text-center d-flex flex-columns">
                    <div class="col-md-4">
                        <div class="row mb-12">
                            <v-select :options="municipios" v-model="municipios" label="municipios" placeholder="Select a user"></v-select>
                        </div>
                        <div class="row mb-12">
                            <div v-for="ruta in rutas" :key="ruta.id" class="row mb-2 col-md-12">
                                <label :for="ruta.id">{{ruta.nombre}}</label>
                                <input type="checkbox" :id="ruta.id" :value="ruta.id" @click="drawRuta(ruta)">
                            </div>
                        </div>
                    </div>
                    <div id="mimapa2" class="col-md-8" style="height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import '../leaflet/leaflet.js';
import '../leaflet/leaflet-routing-machine.js';
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
export default({
    props: ['titulo', 'buscar'],
    data() {
        return {
            mapa: null,
            rutas: [],
            municipios: [],
        }
    },
    components: {
        'v-select': vSelect,
    },
    methods: {
        sincronizar(method, url, data) {
            axios({
                method: method,
                url: url,
                data: data,
            }).then(response => {
                console.log(response);
            }).catch(error => {
                console.log(error);
            });
        },
        conseguirRutas() {
            this.sincronizar('get', '/rutas', {})
            .then(response => {
                this.rutas = response.data;
                console.log(response.data);
                let municipios = [];
                this.rutas.forEach(ruta => {
                    if (municipios.indexOf(ruta.municipio) == -1) {
                        municipios.push(ruta.municipio);
                    }
                });
                this.municipios = municipios;
                // Sacar el recorrido, el recorrido se separa por ; y luego por ,
                // El recorrido debe terminar viendose así [[1,2][1,2]], separando las ; y las ,
                this.rutas.forEach(ruta => {
                    ruta.recorrido = ruta.recorrido.split(';');
                    ruta.recorrido.forEach(recorrido => {
                        recorrido = recorrido.split(',');
                        recorrido = recorrido.map(coordenada => {
                            coordenada = coordenada.split(' ');
                            return [parseFloat(coordenada[0]), parseFloat(coordenada[1])];
                        });
                        ruta.recorrido = recorrido;
                    });
                });
            }).catch(error => {
                console.log(error);
            });
        },
        drawRuta(ruta) {
            if (this.mapa == null) {
                this.mapa = L.map('mimapa2').setView([19.4326, -99.1332], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(this.mapa);
            }
            if (ruta.recorrido.length > 0) {
                L.Routing.control({
                    waypoints: {
                        latLngs: ruta.recorrido,
                    },
                }).addTo(this.mapa);
            }
        },
    },
    mounted() {
        this.mapa = L.map('mimapa2').setView([-34.603722, -58.381592], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(this.mapa);

        let route = '13.342642380218225,-88.39153289794922;13.340972096562783,-88.42002868652345;13.344306127847219,-88.43616485595705;13.355663672110932,-88.42964172363281;13.358168940817684,-88.43539237976076;13.359171041017222,-88.44088554382326;13.359922613435444,-88.44697952270509;13.357500871705762,-88.45152854919435;13.352239762819204,-88.45693588256837;13.345057746547587,-88.46526145935059;13.341967743600684,-88.46869468688965;13.34021394056204,-88.47925186157228;13.341869223008556,-88.42496395111085;13.34278787703673,-88.43028545379639;13.343511118890152,-88.43444824218751;13.347707640518639,-88.436336517334;13.349189976500867,-88.43571424484254;13.351027225370173,-88.43358993530275;13.353198501462149,-88.43236684799194';
        let recorrido = route.split(';');
        recorrido = recorrido.map(coordenada => {
            coordenada = coordenada.split(',');
            return L.latLng(parseFloat(coordenada[0]), parseFloat(coordenada[1]));
        });
        L.Routing.control({
            waypoints: recorrido,
            // los wayspoints no deben mostrar un icono
            show: false,
            
        }).addTo(this.mapa);
    }
})
</script>

<style>
@import url('https://unpkg.com/leaflet@1.8.0/dist/leaflet.css');
@import url('https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css');
</style>
