<template>


    <main class="mt-10 w-full max-w-[1400px] mx-auto px-4 md:flex">

        <div class="flex-1">
            <img 
                alt="user header" 
                src="https://primefaces.org/cdn/primevue/images/card-vue.jpg" />

            <h2 class="text-3xl font-normal mt-10">{{ article?.title }}</h2>

            <div class="sm:flex items-center gap-3 mt-4">
                <div class="w-10 h-10 rounded-full bg-gray-400 flex items-center justify-center">
                    <User />
                </div>


                <p class="text-gray-600">
                    por
                    <span class="text-white">
                        <b>{{ article?.user.name }}</b>
                    </span>
                </p>

                <p class="flex items-center gap-2 text-gray-300">
                    <clock :size="16" />
                    {{ formatDate(article?.created ?? '') }}
                </p>
            </div>


            <section class="mt-6">
                {{ article?.content }}
            </section>
        </div>

        <aside class="flex-1 max-w-[300px] px-4 py-10">
            <h2 class="text-2xl font-bold border-b border-b-gray-400">Tags</h2>

            <ul class="flex flex-wrap gap-2 mt-10">
                <li 
                    v-for="(tag, index) in article?.tags"
                    :key="index"
                    class="bg-green-600 px-1 rounded-sm">
                        {{ tag.title }}
                </li>
            </ul>
        </aside>

    </main>


</template>

<script setup lang="ts">


import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import { User, Clock } from 'lucide-vue-next'


import { ArticleViewType } from '../interfaces/articles'
import { getArticleWithId } from '../services/Articles'
import { formatDate } from '../utils/format'


const route = useRoute()
const article = ref<ArticleViewType>()


onMounted(handlerGetArticle)



async function handlerGetArticle() {
    const articleId = route.params.id as string

    const articleResponse = await getArticleWithId(articleId)
    article.value = articleResponse
}

</script>
