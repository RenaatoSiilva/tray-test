import { defineStore } from 'pinia'

export const useSellerListCache = defineStore('cache', {
  state: () => ({
    cache: [],
  }),
  actions: {

    setSellerListCache(data) {
      this.cache = data
    },

  }
})
