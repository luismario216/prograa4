/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
window.socketio = io('http://localhost:3000');
socketio.on('connect', function(e){
    console.log('Conectado a socket.io');
});
if (!Notification) {
    console.log('El navegador no soporta notificaciones');
}
window.norificable = 'default';
if (Notification.permission !== "denied") {
    Notification.requestPermission(function (status) {
        norificable = status;
    });
} else {
    console.log('El usuario rechazo las notificaciones');
    norificable = 'denied';
}
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('ajustes-component', require('./components/ExampleComponent.vue').default);
// Vue.component('contacto-component', require('./components/AgregarContacto.vue').default);
// Vue.component('mis-contactos', require('./components/MisContactos.vue').default);
// Vue.component('mi-ubicacion', require('./components/MiUbicacion.vue').default);
// Vue.component('rutas-component', require('./components/Rutas.vue').default);
import ajustes from './components/ExampleComponent.vue';
import contacto from './components/AgregarContacto.vue';
import miscontactos from './components/MisContactos.vue';
import miubicacion from './components/MiUbicacion.vue';
import rutas from './components/Rutas.vue';


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        vistas: {
            ajustes: {mostrar: false},
            contacto: {mostrar: false},
            misContactos: {mostrar: false},
            miUbicacion: {mostrar: false},
            rutas: {mostrar: false}
        },
    },
    components: {
        'ajustes-component': ajustes,
        'contacto-component': contacto,
        'mis-contactos': miscontactos,
        'mi-ubicacion': miubicacion,
        'rutas-component': rutas,
    },
    methods: {
        abrir(vista) {
            for (let v in this.vistas) {
                console.log(v, vista);
                if (vista == v) {
                    this.vistas[v].mostrar = !this.vistas[v].mostrar;
                }
                else {
                    this.vistas[v].mostrar = false;
                }
            }
        }
    },
    mounted() {
        let user_id = document.getElementById('user_id').innerHTML;
        socketio.on(user_id, (data) => {
            console.log('recibi: ',data);
            if (norificable == 'granted') {
                let notificacion = new Notification(data.titulo, {
                    body: data.mensaje,
                    icon: 'http://localhost:3000/img/logo.png'
                });
            }
        });
    }

});
