import { defineStore } from 'pinia'

export const useSaleStore = defineStore('sale', {
  state: () => ({
    currentSale: null,
    sales: []
  }),
  actions: {
    setCurrentSale(sale) {
      this.currentSale = sale
    },
  }
})