import { createApp } from 'vue'
import App from './App.vue'

import './css/reset.css'

import Primevue from 'primevue/config'
import Aura from '@primevue/themes/lara'

import { router } from './router'


createApp(App)
    .use(Primevue, {
        theme: {
            preset: Aura
        }
    })
    .use(router)
    .mount('#app')
