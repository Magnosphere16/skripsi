require('./bootstrap');

window.Vue = require('vue').default;

// Axios
import {Form} from 'vform';
import {HasError, AlertError} from 'vform/src/components/bootstrap4'

// buat cek inputan
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);


let Fire =new Vue();
window.Fire = Fire;

//Import Alert
import Swal from 'sweetalert2'
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.Toast = Toast;

//Import Progress Bar
import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar,{
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '5px'
});


import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

//direct ke page component, path adalah nama url yang digunakan untuk mengakses component konsep sama sprt web.php
let routes =[
    {path: '/items', component:require('./components/items.vue').default},
    {path: '/transactions', component:require('./components/transactions.vue').default}
]


//per component fragment untuk di put ke dalam blade
Vue.component('new-component', require('./components/ExampleComponent.vue').default);

const router = new VueRouter ({
    routes
})

const app = new Vue({
    el: '#app',
    router
});
