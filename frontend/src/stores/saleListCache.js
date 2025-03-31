import { defineStore } from 'pinia'

export const useSaleListCache = defineStore('cache', {
  state: () => ({
    cache: localStorage.getItem('salesCache') || [],
  }),
  actions: {
    setSalesListCache(data) {
      this.cache = JSON.stringify(data)
      localStorage.setItem('salesCache', this.cache)
    },

    checkSalesCache() {

      const storedData = localStorage.getItem('salesCache') || []

      if (storedData) {
        this.cache = storedData
        return JSON.parse(this.cache)
      }
    },
  }
})
