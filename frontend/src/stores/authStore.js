import { defineStore } from 'pinia'
import router from '@/router' 

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: localStorage.getItem('authToken') || null,
    user: null,
    isAuthenticated: false
  }),

  actions: {
    setToken(token) {
      this.token = token
      this.isAuthenticated = !!token

      if (token) {
        localStorage.setItem('authToken', token)
      } else {
        localStorage.removeItem('authToken')
        router.push('/login')
      }
    },

    checkAuth() {
      if (!this.token) {
        router.push('/login')
        return false
      }
      return true
    },

    logout() {
      this.setToken(null)
      this.user = null
      router.push('/login')
    }
  },

  getters: {
    authHeaders: (state) => {
      if (!state.token) return { 'Content-Type': 'application/json' }
      return {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${state.token}`
      }
    }
  }
})