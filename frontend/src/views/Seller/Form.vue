<template>

    <div v-if="!dataLoaded" class="skeleton h-10 w-full"></div>

    <div class="form-container" v-if="dataLoaded">
        <form @submit.prevent="handleSubmit" class="sales-form space-y-4">
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nome</legend>
                <input id="name" v-model="formData.name" class="input" />
            </fieldset>

            <fieldset class="fieldset">
                <legend class="fieldset-legend">E-Mail</legend>
                <input id="amount" v-model="formData.email" class="input" />

            </fieldset>

            <br>

            <Button :label="editing ? 'Atualizar' : 'Salvar'" customClass="btn btn-primary" />

        </form>
    </div>
</template>

<script setup>

import { ref, onMounted, onBeforeMount, computed, reactive, watchEffect, watch, onUpdated, onActivated } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import api from "@/services/api.js";
import Button from "@/components/Form/Button.vue"
import Swal from 'sweetalert2'
import { useSweetAlert } from "@/composables/useSweetAlert";
import { useSellerStore } from '@/stores/sellerStore';
/** Router */
const route = useRoute();
const router = useRouter();
const sellerStore = useSellerStore();

/** Form Updating Or Creating */
const editing = ref(false);
const dataLoaded = ref(true);

/** Form Data */
const formData = reactive({
    email: null,
    name: null,
});


onBeforeMount(() => {

    if (route.params.id) {
        if (sellerStore.currentSeller) {
            formData.email = sellerStore.currentSeller.email;
            formData.name = sellerStore.currentSeller.name;
            return;
        } else {
            fetchData();
        }
    }
});


const { questionAlert, successAlert, errorAlert, infoAlert } = useSweetAlert();

/** Create Sale */
const createSeller = async () => {

    try {

        const response = await api.sellers.store(formData);

        if (response.status == '200') {

            await successAlert({
                title: "Vendedor Adicionado !",
            })

            router.push('/sellers');

            return;

        }

        if (response.status == '403') {

            const alertMessages = await response.json();

            const errorMessages = Object.values(alertMessages.messages)
                .flat()
                .join(', ');

            await Swal.fire({
                title: 'Dados Inválidos!',
                text: errorMessages,
                icon: 'error',
                confirmButtonText: 'Entendi!'
            })

            return;
        }


    } catch (error) {
        alert('Erro ao adicionar o vendedor(a) !' + error.messages)
    }
}

/** Update Seller */
const updateSeller = async () => {

    try {

        const response = await api.sellers.update(route.params.id, formData);

        if (response.status == '200') {


            await infoAlert({
                title: "Vendedor Atualizado !",
                text: "Tudo OK!"
            })

            router.push('/sellers');

            return;

        }

        if (response.status == '403') {
            const alertMessages = await response.json();

            const errorMessages = Object.values(alertMessages.messages)
                .flat()
                .join(', ');

            await errorAlert({
                title: 'Dados Inválidos!',
                text: errorMessages,
            });

            return;
        }


    } catch (error) {
        alert('Erro ao adicionar o vendedor(a) !' + error.messages)
    }
}

/** Fetch Form Data */
const fetchData = async () => {
    try {

        dataLoaded.value = false;

        const response = await api.sellers.getById(route.params.id)

        if (!response.ok) {
            throw new Error('Falha na requisição');
        }

        const data = await response.json();

        formData.email = data.email;
        formData.name = data.name;

        dataLoaded.value = true;
    } catch (error) {
        console.error('Erro ao buscar dados:', error);
    }
};

const handleSubmit = () => {
    if (route.params.id) {
        updateSeller();
    } else {
        createSeller();
    }
};

</script>