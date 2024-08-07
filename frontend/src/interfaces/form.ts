import { UserType } from "./user"

export interface LoginForm {
    email: string
    password: string
}


export interface LoginSuccessType {
    token: string
    user: UserType
}


