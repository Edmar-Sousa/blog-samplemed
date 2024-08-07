<template>

    <header class="h-[80px] w-full px-4">
        <nav class="w-full max-w-[1400px] h-[80px] mx-auto flex items-center justify-between">
            <h1 class="font-nunito text-3xl">Blog Semplemed</h1>

            <div v-if="!authStore.authenticated">
                <router-link 
                    :to="{ name: 'login' }"
                    class="px-4 py-2 bg-green-600 rounded-md mr-4">
                        Login
                </router-link>
    
                <router-link 
                    to="#"
                    class="px-4 py-2 bg-green-600 rounded-md">
                        registre-se
                </router-link>
            </div>

            <div v-else class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gray-400 flex items-center justify-center">
                    <User />
                </div>

                <div>
                    <p class="text-white">
                        <b>{{ authStore.user.name }}</b> <br />
                        {{ authStore.user.username }}
                    </p>
                </div>
            </div>
        </nav>
    </header>

    <router-view />

</template>


<script setup lang="ts">

import { User } from 'lucide-vue-next'
import { useAuthStore } from './stores/useAuth'


const authStore = useAuthStore()

</script>
