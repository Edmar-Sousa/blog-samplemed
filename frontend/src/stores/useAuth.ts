import { defineStore } from 'pinia'
import { UserType } from '../interfaces/user'
import { AuthStoreType } from '../interfaces/auth'



export const useAuthStore = defineStore('auth', {

    state: (): AuthStoreType => ({
        authenticated: false,
        token: '',
        user: {
            id: '',
            username: '',
            name: '',
            email: '',
        }
    }),


    actions: {
        authUser(token: string, user: UserType) {
            this.authenticated = true
            this.token = token
            this.user = user
        }
    }
})

