import { UserType } from "./user"

export interface AuthStoreType {
    authenticated: boolean
    token: string
    user: UserType
}
