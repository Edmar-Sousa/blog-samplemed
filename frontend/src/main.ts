import { createApp } from 'vue'
import App from './App.vue'

import './css/reset.css'

import Primevue from 'primevue/config'
import Aura from '@primevue/themes/lara'

import { createPinia } from 'pinia'

import { router } from './router'

const pinia = createPinia()

createApp(App)
    .use(Primevue, {
        theme: {
            preset: Aura
        }
    })
    .use(pinia)
    .use(router)
    .mount('#app')
