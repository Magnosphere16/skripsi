require('./bootstrap');

window.Vue = require('vue').default;

import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

//direct ke page component, path adalah nama url yang digunakan untuk mengakses component konsep sama sprt web.php
let routes =[
    {path: '/items', component:require('./components/items.vue').default}
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
