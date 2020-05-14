import Vue from 'vue'
import VueRouter from 'vue-router'

import VueAxios from 'vue-axios';
import axios from 'axios';

window.Vue = Vue;
Vue.use(VueRouter);
Vue.use(VueAxios, axios);



