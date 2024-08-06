import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'


const routes: Array<RouteRecordRaw> = [
    { path: '/', component: () => import('./pages/Articles.vue') },
]


const router = createRouter({
    history: createWebHistory(),
    routes
})

export { router }
