import { defineStore } from 'pinia'

export const useSellerStore = defineStore('seller', {
  state: () => ({
    currentSeller: null,
    seller: []
  }),
  actions: {
    setCurrentSeller(seller) {
      this.currentSeller = seller
    },
  }
})