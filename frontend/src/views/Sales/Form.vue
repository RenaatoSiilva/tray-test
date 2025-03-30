<template>
    <div class="form-container">
        <form @submit.prevent="handleSubmit" class="sales-form space-y-4">
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Vendedor</legend>
                <select id="seller" v-model="formData.seller_id" class="select mb-2" required>
                    <option v-for="seller in sellersList" :key="seller.id" :value="seller.id">
                        {{ seller.name }}
                    </option>
                </select>
            </fieldset>

            <fieldset class="fieldset">
                <legend class="fieldset-legend">Valor</legend>
                <input id="amount" v-model="formData.amount" class="input" required />
                <p>Comissão: 8.5%</p>
                <p>Valor Total: {{ totalWithCommission }}</p>
            </fieldset>


            <fieldset class="fieldset">
                <legend class="fieldset-legend">Data</legend>
                <input id="date" v-model="formData.date" type="date" class="input" required />
            </fieldset>

            <br>

            <Button :label="editing ? 'Atualizar' : 'Salvar'" customClass="btn btn-primary"
                @click="route.params.id ? updateSale() : createSale()" />


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

/** Form Data */
const editing = ref(false);
const sellers = ref([]);
const commissionPercentage = 8.5;
const sellersList = ref([]);

const formData = reactive({
    seller_id: null,
    amount: 0,
    date: null,
});

const totalWithCommission = computed(() => {
    return (Number(formData.amount) + Number((formData.amount * (commissionPercentage / 100)).toFixed(2))).toFixed(2);

});

/** Load Sellers */
const loadSellers = async () => {
    try {
        const response = await api.sellers.getAll();

        const data = await response.json();

        sellersList.value = data;

    } catch (error) {

        alert('Erro ao carregar os vendedores.')
    }
}

/** Fetch Form Data */
const fetchData = async () => {
    try {

        const response = await api.sales.getById(route.params.id)

        if (!response.ok) {
            throw new Error('Falha na requisição');
        }

        const data = await response.json();

        formData.seller_id = data.seller_id;
        formData.amount = data.amount;
        formData.date = data.date;

        editing.value = true;

    } catch (error) {
        console.error('Erro ao buscar dados:', error);
    }
};

/** Update Sale */
const updateSale = async () => {

    try {

        const response = await api.sales.update(route.params.id, formData);

        if (response.ok) {
            alert('Venda Atualizada!');
            router.push('/sales')
        }

    } catch (error) {
        alert('Erro ao atualizar a venda!')
    }
}

/** Create Sale */
const createSale = async () => {

    try {

        const response = await api.sales.store(formData);

        if (response.ok) {
            alert('Venda Adicionada!');
            router.push('/sales')
        }

    } catch (error) {
        alert('Erro ao adicionar a venda!')
    }
}

onBeforeMount(() => {

    loadSellers();

    if (route.params.id) {
        fetchData();
    }
});

</script>

<style scoped></style>
