<template>
    <div class="form-container">
        <form @submit.prevent="handleSubmit" class="sales-form space-y-4">
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nome</legend>
                <input id="name" v-model="formData.name" class="input" required />
            </fieldset>

            <fieldset class="fieldset">
                <legend class="fieldset-legend">E-Mail</legend>
                <input id="amount" v-model="formData.email" class="input" required />

            </fieldset>

            <br>

            <Button :label="editing ? 'Atualizar' : 'Salvar'" customClass="btn btn-primary"
                @click="route.params.id ? updateSeller() : createSeller()" />
        </form>
    </div>
</template>

<script setup>

import { ref, onMounted, onBeforeMount, computed, reactive } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import api from "@/services/api.js";
import Button from "@/components/Form/Button.vue"

/** Router */
const route = useRoute();
const router = useRouter();

/** Form Updating Or Creating */
const editing = ref(false);

/** Form Data */
const formData = reactive({
    email: null,
    name: null,
});

/** Create Sale */
const createSeller = async () => {

    try {

        const response = await api.sellers.store(formData);

        if (response.ok) {
            alert('Vendedor Adicionado(a) !');
            router.push('/sellers')
        }

    } catch (error) {
        alert('Erro ao adicionar o vendedor(a) !')
    }
}

/** Fetch Form Data */
const fetchData = async () => {
    try {

        const response = await api.sellers.getById(route.params.id)

        if (!response.ok) {
            throw new Error('Falha na requisição');
        }

        const data = await response.json();

        formData.email = data.email;
        formData.name  = data.name;

        editing.value = true;

    } catch (error) {
        console.error('Erro ao buscar dados:', error);
    }
};

onBeforeMount(() => {

    if (route.params.id) {
        fetchData();
    }
});

</script>