<template>

    <div v-if="isLoading" class="skeleton h-10 w-full"></div>


    <div v-if="!isLoading">

        <router-link class="btn btn-soft" :to="`/sellerStore`">
            ➕ Cadastrar Vendedor
        </router-link>

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
                                    params: { id: row.id },
                                }" @click="setSellerToEdit(row)">
                                    🖊️ Editar
                                </router-link>
                            </div>
                            &nbsp;
                            <div class="btn btn-soft btn-error">
                                <Button @click="prepareDelete(row.id)" :label="`🗑️ Deletar`" />
                            </div>
                            &nbsp;
                            <div class="btn btn-neutral">
                                <Button @click="sendCommissionReport(row.id)" :label="`📝 Enviar Relatório`" />
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
import { useSellerStore } from '@/stores/sellerStore';
import api from "@/services/api.js";
import Button from '../Form/Button.vue';
import { useSweetAlert } from "@/composables/useSweetAlert";
import { useSellerListCache } from '@/stores/sellerListCache';

const tableData = ref([]);
const isLoading = ref(true);
const sellerStore = useSellerStore();
const sellerCache = useSellerListCache();


const { questionAlert, successAlert, errorAlert, infoAlert } = useSweetAlert();

const setSellerToEdit = (seller) => {
    sellerStore.setCurrentSeller(seller)
}

/** Send Commission Report */
const sendCommissionReport = async (sellerId) => {

    const result = await questionAlert({
        title: "Deseja enviar o relatório para esse vendedor ?",
        confirmButtonText: "Sim",
        cancelButtonText: "Não",
        confirmButtonColor: "#9b111e",
    });

    if (result.isConfirmed) {

        try {

            const response = await api.sellers.sendCommissionReport(sellerId);

            if (!response.ok) {
                throw new Error('Falha na requisição');
            }

            await successAlert({
                title: "O relatório será enviado em breve para o vendedor!",
            })

            fetchData();

        } catch (error) {

            await errorAlert({
                title: "Erro ao enviar o relatório!",
            })

        }
    }

}

/** Delete */
const prepareDelete = async (saleId) => {

    const result = await questionAlert({
        title: "Deseja excluir esse vendedor ? Todas as vendas relacionadas serão excluidas",
        confirmButtonText: "Sim",
        cancelButtonText: "Não",
        confirmButtonColor: "#9b111e",
    });

    if (result.isConfirmed) {

        try {
            const response = await api.sellers.delete(saleId);

            if (!response.ok) {
                throw new Error('Falha na requisição');
            }

            await successAlert({
                title: "Vendedor Deletado !",
            })

            fetchData();
        } catch (error) {

            await errorAlert({
                title: "Erro ao deletar o(a) vendedor(a)",
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

    if (!sellerCache.checkSellersCache()) {

        try {

            const response = await api.sellers.getAll();

            if (!response.ok) {
                throw new Error('Falha na requisição');
            }

            const data = await response.json();

            tableData.value = data;

            sellerCache.setSellerListCache(data);

        } catch (error) {
            console.error('Erro ao buscar dados:', error);
        } finally {
            isLoading.value = false;
        }

    } else {

        tableData.value = sellerCache.checkSellersCache();

        isLoading.value = false;

    }
};

onMounted(() => {
    fetchData();
});

</script>

<style scoped></style>