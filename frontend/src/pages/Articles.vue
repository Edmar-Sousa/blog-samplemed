<template>


    <main class="mt-10 w-full max-w-[1400px] mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <template v-if="!isLoadding">
                <card 
                    class="w-full" 
                    v-for="(article, index) in articleStore.articles"
                    :key="index">
                        <template #header>
                            <img 
                                alt="user header" 
                                src="https://primefaces.org/cdn/primevue/images/card-vue.jpg"
                                class="rounded-t-md" />
                        </template>
    
                        <template #title>
                            <router-link :to="{ name: 'view-article', params: { id: article.id } }">
                                    {{ article.title }}
                            </router-link>
                        </template>
    
                        <template #content>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gray-400 flex items-center justify-center">
                                    <User />
                                </div>
            
                                <div>
                                    <p class="text-gray-600">
                                        por
                                        <span class="text-white">
                                            <b>{{ article.user.name }}</b>
                                        </span>
                                    </p>
            
                                    <p class="flex items-center gap-2 text-gray-300">
                                        <clock :size="16" />
                                        {{ formatDate(article.created) }}
                                    </p>
                                </div>
                            </div>
                        </template>
                </card>
    
    
            </template>
    
            <template v-if="isLoadding">
                <card 
                    v-for="card in skeletonCards"
                    :key="card"
                    class="w-[300px]" v-if="isLoadding">
                        <template #header>
                            <Skeleton class="w-full !h-[159px] !rounded-b-none" />
                        </template>
            
                        <template #title>
                            <Skeleton class="w-full !h-8" />
                        </template>
            
                        <template #content>
                            <div class="flex items-center gap-3">
                                <Skeleton class="!w-10 !h-10 !rounded-full" />
            
                                <div class="flex-1">
                                    <Skeleton class="w-full !h-10" />
            
                                </div>
                            </div>
                        </template>
                </card>
            </template>
        </div>
    </main>

</template>


<script setup lang="ts">


import Card from 'primevue/card'
import Skeleton from 'primevue/skeleton'

import { User, Clock } from 'lucide-vue-next'

import { computed, onMounted } from 'vue'
import { useArticlesStore } from '../stores/useArticles'
import { formatDate } from '../utils/format'



const articleStore = useArticlesStore()


onMounted(() => {
    articleStore.fetchArticles()
})


const skeletonCards = new Array(4)
const isLoadding = computed(() => articleStore.loading)


</script>
