import { UserType } from "./user"

export interface LoginForm {
    email: string
    password: string
}


export interface LoginSuccessType {
    token: string
    user: UserType
}


export interface LoginErrorType {
    message: string
    details: {
        email?: string | null
        password?: string | null
    }
}


