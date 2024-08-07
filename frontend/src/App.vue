<template>

    <header class="h-[80px] w-full px-4">
        <nav class="w-full max-w-[1400px] h-[80px] mx-auto flex items-center justify-between">
            <h1 class="font-nunito text-3xl">Blog Semplemed</h1>

            <div>
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
        </nav>
    </header>

    <router-view />

</template>