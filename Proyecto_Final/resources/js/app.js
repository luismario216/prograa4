/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('ajustes-component', require('./components/ExampleComponent.vue').default);
Vue.component('contacto-component', require('./components/AgregarContacto.vue').default);
Vue.component('mis-contactos', require('./components/MisContactos.vue').default);

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
            misContactos: {mostrar: false}
        },
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
    }
});
