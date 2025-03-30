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
import Swal from 'sweetalert2'

const tableData = ref([]);
const isLoading = ref(true);
const saleStore = useSaleStore()

const setSaleToEdit = (sale) => {
    saleStore.setCurrentSale(sale)
}

const prepareDelete = async (saleId) => {

    const result = await Swal.fire({
        title: "Deseja excluir essa venda?",
        showCancelButton: true,
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

            await Swal.fire("Venda deletada!", "", "success");

            fetchData();
        } catch (error) {
            console.error('Erro ao deletar a venda');
            await Swal.fire("Erro ao deletar a venda", "", "error");
        }
    } else {
        await Swal.fire("Operação Cancelada", "", "info");
    }
};


/** Load Data */
const fetchData = async () => {
    try {

        const response = await api.sales.getAll();

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