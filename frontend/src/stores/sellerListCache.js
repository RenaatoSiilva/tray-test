import { defineStore } from 'pinia'

export const useSellerListCache = defineStore('cache', {
  state: () => ({
    cache: localStorage.getItem('sellersCache') || [],
  }),
  actions: {
    setSellerListCache(data) {
      this.cache = JSON.stringify(data)
      localStorage.setItem('sellersCache', this.cache)
    },

    checkSellersCache() {

      const storedData = localStorage.getItem('sellersCache') || []

      if (storedData) {
        this.cache = storedData
        return JSON.parse(this.cache)
      }
    },
  }
})
