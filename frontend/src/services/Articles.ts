import axios from 'axios'

import { ArticleType, ArticleViewType } from '../interfaces/articles'
import { http } from '../http/axios'



export async function getLatestArticles(): Promise<Array<ArticleType>> {
    try {
        const response = await http.get<Array<ArticleType>>('/api/articles.json', {
            params: {
                page: 1,
            }
        })


        return response.data
    }

    catch (err) {

        if (axios.isAxiosError(err))
            throw new Error(err.response?.data.message)

        throw new Error('Erro ao buscar postagens')
    }
}



export async function getArticleWithId(articleId: string): Promise<ArticleViewType> {
    try {
        const response = await http.get(`/api/articles/${articleId}.json`)

        return response.data
    }

    catch (err) {
        if (axios.isAxiosError(err))
            throw new Error(err.response?.data.message)

        throw new Error('Erro ao buscar postagem')
    }
}
