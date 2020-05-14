require('./bootstrap');
import App from './App.vue';
import router from './router'


const app = new Vue(Vue.util.extend({ router }, App)).$mount('#app');
