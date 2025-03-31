import { defineStore } from 'pinia'

export const useSaleListCache = defineStore('cacheSale', {
    state: () => ({
        cache: localStorage.getItem('salesCache') || [],
    }),
    actions: {
        setSalesListCache(data) {
            this.cache = JSON.stringify(data)
            localStorage.setItem('salesCache', this.cache)
        },

        checkSalesCache() {
            const storedData = localStorage.getItem('salesCache');

            if (!storedData) {
                return false;
            }

            this.cache = JSON.parse(storedData);
            return this.cache;
        },

        removeCache() {
            localStorage.removeItem('salesCache')
        }

    }
})
