import Vue from 'vue'
import VueRouter from 'vue-router'

import VueAxios from 'vue-axios';
import axios from 'axios';

window.Vue = Vue;
window.axios = axios;
Vue.use(VueRouter);
Vue.use(VueAxios, axios);

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}


