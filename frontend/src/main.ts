import { createApp } from 'vue'
import App from './App.vue'

import Primevue from 'primevue/config'
import Aura from '@primevue/themes/aura'

createApp(App)
    .use(Primevue, {
        theme: {
            preset: Aura
        }
    })
    .mount('#app')
