import { defineStore } from 'pinia'
import { getLatestArticles } from '../services/Articles'

import { ArticleStoreType } from '../interfaces/articles'


export const useArticlesStore = defineStore('article', {
    state: (): ArticleStoreType => ({
        loading: false,
        error: false,
        errorMessage: '',
        articles: [],
    }),


    actions: {
        async fetchArticles() {
            this.loading = true

            try {
                const articles = await getLatestArticles()
                this.articles = articles
            }

            catch (err) {
                this.error = true
                this.errorMessage = (err as Error).message
            }

            this.loading = false
        }
    }
})

