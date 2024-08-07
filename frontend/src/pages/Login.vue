<template>

    <div class="w-full h-[90vh] flex items-center justify-center">

        <form action="#" method="POST" @submit.prevent>
            <h2 class="text-2xl mb-4 text-center">Login</h2>

            <div>
                <text-input
                    type="text"
                    placeholder="E-mail"
                    :error="v$.email?.$errors[0]?.$message ?? errors?.email"
                    v-model="loginForm.email" />
            </div>


            <div class="mt-8">
                <text-input
                    type="password"
                    placeholder="Senha"
                    :error="v$.password?.$errors[0]?.$message ?? errors?.password"
                    v-model="loginForm.password" />
            </div>


            <button
                class="w-full h-[65px] rounded-md bg-green-600 font-bold mt-4"
                @click="handlerSubmitForm">
                    Entrar
            </button>
        </form>

    </div>

</template>


<script setup lang="ts">


import { ref } from 'vue'
import { email, helpers, required } from '@vuelidate/validators'
import { loginUser } from '../services/user'
import { useAuthStore } from '../stores/useAuth'
import { useRouter } from 'vue-router'

import TextInput from '../components/TextInput.vue'
import useVuelidate from '@vuelidate/core'
import { LoginException } from '../Exception/LoginException'



const loginForm = ref({
    email: '',
    password: '',
})

const rules = {
    email: {
        email: helpers.withMessage('Digite um email valido', email),
        required: helpers.withMessage('O campo é obrigatorio', required)
    },
    password: {
        required: helpers.withMessage('O campo é obrigatorio', required)
    }
}

const v$ = useVuelidate(rules, loginForm)

const authStore = useAuthStore()
const router = useRouter()

const errors = ref({
    email: null,
    password: null,
})

async function handlerSubmitForm() {
    v$.value.$validate()

    if (v$.value.$error)
        return 

    try {
        const response = await loginUser(loginForm.value)
        authStore.authUser(response.token, response.user)
    
        router.push({ name: 'home' })

    }
    catch (err) {

        if (err instanceof LoginException) {
            const errorsApi = err.getErrors()
            /// @ts-ignore
            errors.value = errorsApi
        }

        // TODO toas notification when erro 
    }
}

</script>
