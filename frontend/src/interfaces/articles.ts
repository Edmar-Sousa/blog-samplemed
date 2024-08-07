import { UserType } from './user'


export interface ArticleType {
    id: string
    title: string
    banner_image: string
    content: string
    created: string
    modified: string
    user: UserType
    user_id: string
}


export interface ArticleStoreType {
    loading: boolean
    error: boolean
    errorMessage: string
    articles: Array<ArticleType>
}
