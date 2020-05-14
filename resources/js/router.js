import Vue from 'vue'
import VueRouter from 'vue-router'
import Index from './components/todos/Index.vue'

const routes = [
    {
        name: 'todos',
        path: '/',
        component: () => import(/* webpackChunkName: "js/todos/index" */ '@components/todos/Index.vue')
    },
    {
        name: 'create',
        path: '/create',
        component: () => import(/* webpackChunkName: "js/todos/create" */ '@components/todos/Create')
    },
    {
        name: 'update',
        path: '/update/:id',
        component: () => import(/* webpackChunkName: "js/todos/update" */ '@components/todos/Update')
    }
];

const router = new VueRouter({
    routes,
    mode: 'history',
})

export default router;