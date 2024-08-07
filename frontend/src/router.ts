import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'


const routes: Array<RouteRecordRaw> = [
    { path: '/', component: () => import('./pages/Articles.vue') },
    { path: '/article/:id', component: () => import('./pages/ArticleView.vue'), name: 'view-article' },
]


const router = createRouter({
    history: createWebHistory(),
    routes
})

export { router }
