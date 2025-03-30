<template>

    <div v-if="isLoading" class="skeleton-container">
        <div v-for="n in 5" :key="'skeleton-' + n" class="skeleton-row">
            <div class="skeleton-cell"></div>
            <div class="skeleton-cell"></div>
            <div class="skeleton-cell"></div>
            <div class="skeleton-cell"></div>
        </div>
    </div>


    <div v-if="!isLoading">

        <div class="btn btn-soft">
            <router-link class="" :to="`/sellerStore`">
                ➕ Cadastrar Vendedor
            </router-link>
        </div>

        <div class="h-full overflow-x-auto">
            <table class="table">
                <thead class="">
                    <tr class="uppercase bold">
                        <th>Nome</th>
                        <th>E-Mail</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in tableData" :key="index">
                        <td>{{ row.name }}</td>
                        <td>{{ row.email }}</td>
                        <td class="flex">

                            <div class="btn btn-warning">
                                <router-link class="" :to="{
                                    name: 'sellerEdit',
                                    params: { id: row.id }
                                }" @click="setSellerToEdit(row)">
                                    🖊️ Editar
                                </router-link>
                            </div>
                            &nbsp;
                            <div class="btn btn-soft btn-error">
                                <button @click="prepareDelete(row.id)">
                                    🗑️ Deletar
                                </button>
                            </div>
                            &nbsp;
                            <div class="btn btn-neutral">
                                <button @click="sendCommissionReport(row.id)">
                                    📝 Enviar Relatório
                                </button>
                            </div>
                            &nbsp;
                            <div class="btn btn-soft">
                                <router-link :to="`/sellerSales/${row.id}`">
                                    🛒 Visualizar Vendas
                                </router-link>
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


const tableData = ref([]);
const isLoading = ref(true);

const saleStore = useSaleStore()

const setSellerToEdit = (sale) => {
    saleStore.setCurrentSale(sale)
}

/** Send Commission Report */
const sendCommissionReport = async (sellerId) => {

    const confirmed = window.confirm("Deseja enviar o relatório para esse vendedor ?");

    if (confirmed) {

        try {

            const response = await api.sellers.sendCommissionReport(sellerId);

            if (!response.ok) {
                throw new Error('Falha na requisição');
            }

            fetchData();

        } catch (error) {
            console.error('Erro deletar a venda');
        }
    }

}

/** Delete */
const prepareDelete = async (sellerId) => {

    const confirmed = window.confirm("Deseja excluir esse vendedor ? Todas as vendas atribuidas a ele vão ser excluidas !");

    if (confirmed) {

        try {

            const response = await api.sellers.delete(sellerId);

            if (!response.ok) {
                throw new Error('Falha na requisição');
            }

            fetchData();

        } catch (error) {
            console.error('Erro deletar a venda');
        }
    }

}

/** Load Data */
const fetchData = async () => {
    try {

        const response = await api.sellers.getAll();

        if (!response.ok) {
            throw new Error('Falha na requisição');
        }

        const data = await response.json();
        tableData.value = data;

    } catch (error) {
        console.error('Erro ao buscar dados:', error);
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => {
    fetchData();
});
</script>

<style scoped>
.skeleton-container {
    width: 100%;
}

.skeleton-row {
    display: flex;
    margin-bottom: 1rem;
}

.skeleton-cell {
    height: 40px;
    background: #e0e0e0;
    border-radius: 4px;
    margin-right: 1rem;
    flex: 1;
    animation: pulse 1.5s infinite ease-in-out;
}

@keyframes pulse {

    0%,
    100% {
        opacity: 1;
    }

    50% {
        opacity: 0.5;
    }
}
</style>