require('./bootstrap');

window.Vue = require('vue').default;

// Import Axios
import {Form} from 'vform';
import {HasError, AlertError} from 'vform/src/components/bootstrap4'

// Import cek inputan
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
    {path: '/sale_transactions', component:require('./components/sale_transactions.vue').default},
    {path: '/purchase_transactions', component:require('./components/purchase_transactions.vue').default},
    {path: '/profile', component:require('./components/profile.vue').default},
    {path: '/newSale', component:require('./components/newSale.vue').default},
    {path: '/newPurchase', component:require('./components/newPurchase.vue').default}
]

//per component fragment untuk di put ke dalam blade
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const router = new VueRouter({
    mode: 'history',
    routes
})

const app = new Vue({
    el: '#app',
    router
});