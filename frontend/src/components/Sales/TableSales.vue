<template>

    <div v-if="isLoading" class="skeleton h-10 w-full"></div>


    <div v-if="!isLoading">

        <router-link class="btn btn-soft" :to="`/saleStore`">
            ➕ Cadastrar Venda
        </router-link>

        <div class="h-full overflow-x-auto">
            <table class="table">
                <thead>
                    <tr class="uppercase bold">
                        <th>Nome do Vendedor</th>
                        <th>Total</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in tableData" :key="index">
                        <td>{{ row.seller.name }}</td>
                        <td>{{ row.amount }}</td>
                        <td>{{ row.date }}</td>
                        <td class="flex">

                            <div class="btn btn-warning">
                                <router-link class="cursor-pointer" :to="{
                                    name: 'saleEdit',
                                    params: { id: row.id }
                                }" @click="setSaleToEdit(row)">
                                    🖊️ Editar
                                </router-link>
                            </div>
                            &nbsp;
                            <div class="btn btn-soft btn-error cursor-pointer">
                                <Button @click="prepareDelete(row.id)" :label="`🗑️ Deletar`" />
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useSaleStore } from '@/stores/saleStore'
import api from "@/services/api.js";
import Button from '../Form/Button.vue';
import { useSweetAlert } from "@/composables/useSweetAlert";
import { useSaleListCache } from '@/stores/saleListCache';

const tableData = ref([]);
const isLoading = ref(true);
const saleStore = useSaleStore()
const salesCache = useSaleListCache();

const { questionAlert, successAlert, errorAlert, infoAlert } = useSweetAlert();

const setSaleToEdit = (sale) => {
    saleStore.setCurrentSale(sale)
}

const prepareDelete = async (saleId) => {

    const result = await questionAlert({
        title: "Deseja excluir essa venda?",
        confirmButtonText: "Sim",
        cancelButtonText: "Não",
        confirmButtonColor: "#9b111e",
    });


    if (result.isConfirmed) {

        try {
            const response = await api.sales.delete(saleId);

            if (!response.ok) {
                throw new Error('Falha na requisição');
            }

            await successAlert({
                title: "Venda deletada!",
            })

            salesCache.removeCache();

            fetchData();
        } catch (error) {

            await errorAlert({
                title: "Erro ao deletar a venda",
            })

        }
    } else if (result.isDenied) {

        await infoAlert({
            title: "Operação Cancelada",
            text: "Você cancelou a operação"
        })

    }
};


/** Load Data */
const fetchData = async () => {



    if (!salesCache.checkSalesCache()) {

        try {

            console.log(salesCache.checkSalesCache() == [])

            const response = await api.sales.getAll();

            if (!response.ok) {
                throw new Error('Falha na requisição');
            }

            const data = await response.json();

            tableData.value = data;

            console.log(data)

            salesCache.setSalesListCache(data);

        } catch (error) {
            console.error('Erro ao buscar dados:', error);
        } finally {
            isLoading.value = false;
        }

    } else {

        tableData.value = salesCache.checkSalesCache();

        isLoading.value = false;

    }
};

onMounted(() => {
    fetchData();
});
</script>

<style scoped></style>