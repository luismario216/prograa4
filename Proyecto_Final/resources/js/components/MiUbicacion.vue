<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 text-left">
                            <h4>{{titulo}}</h4>
                        </div>
                        <div class="col-md-3 text-right">
                            <button type="button" class="btn btn-primary" id="ubicarme">
                                {{encontrar}}
                            </button>
                        </div>
                        <div class="col-md-3 text-right">
                            <button type="button" class="btn btn-primary" id="compartir">
                                {{compartir}}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body text-center">
                    <div id="mimapa" class="col-md-12" style="height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import '../leaflet/leaflet.js';
import '../leaflet/leaflet-routing-machine.js';
export default({
    props: ['titulo', 'encontrar', 'compartir', 'user'],
    data() {
        return {
            mapa: null,
            miubicacion: {},
        }
    },
    methods: {
    },
    mounted() {
        this.mapa = L.map('mimapa').setView([-34.603722, -58.381592], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(this.mapa);
        // L.Routing.control({
        //     waypoints: [
        //         L.latLng(-34.603722, -58.381592),
        //         L.latLng(-34.603722, -58.381592),
        //     ],
        //     routeWhileDragging: true,
        //     geocoder: L.Control.Geocoder.nominatim(),
        //     showAlternatives: true,
        //     altLineOptions: {
        //         styles: [{color: 'black', opacity: 0.15, weight: 9}, {color: 'white', opacity: 0.8, weight: 6}, {color: 'blue', opacity: 0.5, weight: 2}]
        //     }
        // }).addTo(this.mapa);
        document.getElementById('ubicarme').addEventListener('click', () => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    let latlng = L.latLng(position.coords.latitude, position.coords.longitude);
                    axios.get('https://nominatim.openstreetmap.org/reverse?format=json&lat=' + latlng.lat + '&lon=' + latlng.lng)
                        .then(response => {
                            this.miubicacion.nombre = response.data.display_name;
                            this.miubicacion.latitud = position.coords.latitude;
                            this.miubicacion.longitud = position.coords.longitude;
                        })
                        .catch(error => {
                            alert('No se pudo encontrar el nombre de la ciudad');
                        });
                    let marker = L.marker(latlng).addTo(this.mapa);
                    marker.bindPopup('<b>Estás aquí</b>').openPopup();
                    this.mapa.setView(latlng, 15);
                });
            }
        });
        document.getElementById('compartir').addEventListener('click', () => {
            let data;
            if (this.miubicacion.nombre) {
                data = {
                    nombre: this.miubicacion.nombre,
                    latitud: this.miubicacion.latitud,
                    longitud: this.miubicacion.longitud,
                    user: this.user
                };
            } else {
                if (navigator.geolocation) {
                    Promise.resolve(navigator.geolocation.getCurrentPosition(position => {
                        let latlng = L.latLng(position.coords.latitude, position.coords.longitude);
                        axios.get('https://nominatim.openstreetmap.org/reverse?format=json&lat=' + latlng.lat + '&lon=' + latlng.lng)
                            .then(response => {
                                this.miubicacion.nombre = response.data.display_name;
                                this.miubicacion.latitud = position.coords.latitude;
                                this.miubicacion.longitud = position.coords.longitude;
                                data = {
                                    nombre: this.miubicacion.nombre,
                                    latitud: this.miubicacion.latitud,
                                    longitud: this.miubicacion.longitud,
                                    user: this.user
                                };
                            })
                            .catch(error => {
                                alert('No se pudo encontrar el nombre de la ciudad');
                            });
                    }));
                } else {
                    alert('No se pudo encontrar tu ubicación');
                }
            }
            if (data) {
                console.log('Antes de los contactos',data);
                Promise.resolve(axios.get('/contactos').then(response => {
                    let contactos = response.data;
                    console.log('Despues de los contactos',contactos);
                    data.contactos = contactos;
                    data.lang = this.encontrar == 'Encuentrame' ? 'es' : 'en';
                    console.log('Antes de enviar el mensaje',data);
                    socketio.emit('ubicacion', data);
                    console.log('Despues de enviar el mensaje');
                }).catch(error => {
                    console.log(error);
                }));
            }
        });
    }
})
</script>

<style>
@import url('https://unpkg.com/leaflet@1.8.0/dist/leaflet.css');
@import url('https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css');
</style>
