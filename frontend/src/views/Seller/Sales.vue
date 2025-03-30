<template>


  <div v-if="salesData.length == 0 && !isLoading">Este vendedor ainda não realizou nenhuma venda.</div>

  <div class="h-96 overflow-x-auto">
    <table class="table table-pin-rows bg-base-200">
      <template v-for="([date, sales]) in Object.entries(salesData)" :key="date">
        <thead>
          <tr @click="toggleCollapse(date)">
            <th class="text-left px-4 py-2 bg-base-300" colspan="5">{{ date }}</th>
          </tr>
          <tr v-if="expandedDates[date]">
            <th>Id</th>
            <th>Vendedor</th>
            <th>Total</th>
            <th>Comissão</th>
            <th>Valor da Comissão</th>
          </tr>
        </thead>
        <tbody>
          <template v-if="expandedDates[date]">
            <tr v-for="sale in sales" :key="sale.id">
              <td class="px-4 py-2">{{ sale.id }}</td>
              <td class="px-4 py-2">{{ sale.seller_id }}</td>
              <td class="px-4 py-2">{{ sale.amount }}</td>
              <td class="px-4 py-2">{{ sale.commission }}%</td>
              <td class="px-4 py-2">{{ sale.commission_value }}</td>
            </tr>
          </template>
        </tbody>
      </template>
    </table>
  </div>


</template>

<script setup>

import { ref, onMounted, onBeforeMount } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import api from "@/services/api.js";

/** Router */
const route = useRoute();
const router = useRouter();

const salesData = ref([]);
const expandedDates = ref({});
const isLoading = ref(true);


/** Fetch Form Data */
const getSales = async () => {
  try {

    const response = await api.sellers.getSalesBySellerIdGroupedDays(route.params.id)

    if (!response.ok) {
      throw new Error('Falha na requisição');
    }

    const data = await response.json();

    salesData.value = data;

    const firstDate = Object.keys(data)[0];
    if (firstDate) {
      expandedDates.value[firstDate] = true;
    }

    console.log(data)

  } catch (error) {
    console.error('Erro ao buscar dados:', error);
  } finally {
    isLoading.value = false;
  }
};

const toggleCollapse = (date) => {
  expandedDates.value[date] = !expandedDates.value[date];
};

onBeforeMount(() => {

  getSales();

});

</script>

