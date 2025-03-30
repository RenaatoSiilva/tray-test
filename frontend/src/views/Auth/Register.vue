<template>

    <div class="form-container">
        <form @submit.prevent="handleRegister()" class="sales-form space-y-4">

            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nome</legend>
                <input id="name" v-model="formData.name" class="input" required />
            </fieldset>

            <fieldset class="fieldset">
                <legend class="fieldset-legend">E-Mail</legend>
                <input id="email" v-model="formData.email" class="input" required />
            </fieldset>


            <fieldset class="fieldset">
                <legend class="fieldset-legend">Senha</legend>
                <input id="password" v-model="formData.password" type="password" class="input" required />
            </fieldset>

            <br>

            <button type="submit" class="btn btn-primary">
                Efetuar Registro
            </button>
        </form>
    </div>

</template>

<script setup>
import { ref, reactive } from 'vue'
import { useAuthStore } from '@/stores/authStore'
import { useRouter } from 'vue-router'
import api from "@/services/api.js";
import { useSweetAlert } from "@/composables/useSweetAlert";

const authStore = useAuthStore()
const router = useRouter()
const { questionAlert, successAlert, errorAlert, infoAlert } = useSweetAlert();

const formData = reactive({
    name: null,
    email: null,
    password: null,
});

const handleRegister = async () => {
    try {
        const response = await api.auth.register(formData);

        const data = await response.json()

        if (response.status == '404') {

            await errorAlert({
                title: "Erro ao efetuar o registro",
            })

            return;
        }

        if (data.token) {
            localStorage.setItem('authToken', data.token)
            localStorage.setItem('authUserName', data.name)
        }

        router.push('/sellers')

    } catch (error) {

        console.error('Login failed:', error)
    }
}
</script>