<template>

    <div v-if="!dataLoaded" class="skeleton h-10 w-full"></div>

    <div class="form-container" v-if="dataLoaded">
        <form @submit.prevent="handleSubmit" class="sales-form space-y-4">
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Vendedor</legend>
                <div v-if="!sellersDataLoaded" class="skeleton h-10 w-64"></div>
                <select id="seller" v-model="formData.seller_id" class="select mb-2" v-if="sellersDataLoaded">
                    <option v-for="seller in sellersList" :key="seller.id" :value="seller.id">
                        {{ seller.name }}
                    </option>
                </select>
            </fieldset>

            <fieldset class="fieldset">
                <legend class="fieldset-legend">Valor</legend>
                <input type="number" id="amount" v-model="formData.amount" class="input" />
                <p>Comissão: 8.5%</p>
                <p>Valor Total: {{ totalWithCommission }}</p>
            </fieldset>

            <fieldset class="fieldset">
                <legend class="fieldset-legend">Data</legend>
                <input id="date" v-model="formData.date" type="date" class="input" />
            </fieldset>

            <br>

            <Button :label="editing ? 'Atualizar' : 'Salvar'" customClass="btn btn-primary" />


        </form>
    </div>
</template>

<script setup>

import { ref, onMounted, onBeforeMount, computed, reactive } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import api from "@/services/api.js";
import Button from "@/components/Form/Button.vue"
import { useSweetAlert } from "@/composables/useSweetAlert";
import { useSaleStore } from '@/stores/saleStore';
import { useSaleListCache } from '@/stores/saleListCache';

/** Router */
const route = useRoute();
const router = useRouter();

/** Form Data */
const editing = ref(false);
const dataLoaded = ref(true);
const sellersDataLoaded = ref(false);
const commissionPercentage = 8.5;
const sellersList = ref([]);
const saleStore = useSaleStore();
const salesCache = useSaleListCache();


const formData = reactive({
    seller_id: null,
    amount: 0,
    date: null,
});


const totalWithCommission = computed(() => {
    return (Number(formData.amount) + Number((formData.amount * (commissionPercentage / 100)).toFixed(2))).toFixed(2);

});

const { questionAlert, successAlert, errorAlert, infoAlert } = useSweetAlert();

/** Load Sellers */
const loadSellers = async () => {
    try {

        sellersDataLoaded.value = false;

        const response = await api.sellers.getAll();

        const data = await response.json();

        sellersList.value = data;

        sellersDataLoaded.value = true;

    } catch (error) {

        alert('Erro ao carregar os vendedores.')
    }
}

/** Fetch Form Data */
const fetchData = async () => {
    try {

        dataLoaded.value = false;

        const response = await api.sales.getById(route.params.id)

        if (!response.ok) {
            throw new Error('Falha na requisição');
        }

        const data = await response.json();

        formData.seller_id = data.seller_id;
        formData.amount = data.amount;
        formData.date = data.date;

        editing.value = true;

        dataLoaded.value = true;


    } catch (error) {
        console.error('Erro ao buscar dados:', error);
    }
};

/** Update Sale */
const updateSale = async () => {

    try {

        const response = await api.sales.update(route.params.id, formData);

        if (response.status == '200') {

            await infoAlert({
                title: "Venda atualizada com sucesso",
                text: "Tudo OK!"
            })

            salesCache.removeCache();

            router.push('/sales')

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
        alert('Erro ao atualizar a venda!')
    }
}

/** Create Sale */
const createSale = async () => {


    try {

        const response = await api.sales.store(formData);

        if (response.status == '200') {

            await successAlert({
                title: "Venda adicionada com sucesso",
            })

            salesCache.removeCache();

            router.push('/sales');

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
        alert('Erro ao adicionar a venda!')
    }
}

onBeforeMount(() => {

    loadSellers();

    if (route.params.id) {

        editing.value = true;

        if (saleStore.currentSale) {
            formData.seller_id = saleStore.currentSale.seller_id;
            formData.amount = saleStore.currentSale.amount;
            formData.date = saleStore.currentSale.date;
            return;
        } else {
            fetchData();
        }
    }
});



const handleSubmit = () => {
    if (route.params.id) {
        updateSale();
    } else {
        createSale();
    }
};

</script>

<style scoped></style>
