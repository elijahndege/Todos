import Vue from 'vue'
import VueRouter from 'vue-router'
import Index from './components/todos/Index.vue'

const routes = [
    {
        name: 'todos',
        path: '/',
        component: () => import(/* webpackChunkName: "js/todos/index" */ '@components/todos/Index.vue')
    },
];

const router = new VueRouter({
    routes,
    mode: 'history',
})

export default router;