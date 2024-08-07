import axios from "axios"

import { http } from "../http/axios"
import { LoginForm, LoginSuccessType } from "../interfaces/form"
import { LoginException } from "../Exception/LoginException"


export async function loginUser(loginForm: LoginForm): Promise<LoginSuccessType> {

    try {
        const response = await http.post('/api/auth/login.json', loginForm, {
            headers: {
                'Content-Type': 'application/json'
            }
        })
        return response.data
    }

    catch (err) {
        if (axios.isAxiosError(err))
            throw new LoginException(
                err.response?.data.message,
                err.response?.data.details
            )

        throw new Error('Erro ao fazer login')
    }

}
