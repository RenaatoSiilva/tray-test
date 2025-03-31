import { defineStore } from 'pinia'

export const useSellerListCache = defineStore('cacheSeller', {
  state: () => ({
    cache: JSON.parse(localStorage.getItem('sellersCache')) || [],
  }),
  actions: {
    setSellerListCache(data) {
      this.cache = data; 
      localStorage.setItem('sellersCache', JSON.stringify(data)); 
    },

    checkSellersCache() {
      const storedData = localStorage.getItem('sellersCache');

      if (!storedData) {
        return false;
      }

      this.cache = JSON.parse(storedData);
      return this.cache;
    },

    removeCache() {
      localStorage.removeItem('sellersCache')
  }
  }
});
