<template>
  <header class="header">
    <nav class="navigation">
      <div class="nav-container">
        <RouterLink 
          to="/sellers" 
          class="nav-link" 
          title="Sellers" 
          v-if="isAuthenticated"
        >
          <span class="icon">👨‍⚕️</span>
          <span class="text">Vendedores</span>
        </RouterLink>
        
        <RouterLink 
          to="/sales" 
          class="nav-link" 
          title="Sales" 
          v-if="isAuthenticated"
        >
          <span class="icon">💰</span>
          <span class="text">Vendas</span>
        </RouterLink>
        
        <RouterLink 
          to="/login" 
          class="nav-link" 
          title="Login" 
          v-if="!isAuthenticated"
        >
          <span class="icon">🔒</span>
          <span class="text">Login</span>
        </RouterLink>

        <RouterLink 
          to="/register" 
          class="nav-link" 
          title="Register" 
          v-if="!isAuthenticated"
        >
          <span class="icon">💾</span>
          <span class="text">Cadastro</span>
        </RouterLink>
        
        <RouterLink 
          to="/logout" 
          class="nav-link" 
          title="Logout" 
          v-if="isAuthenticated"
        >
          <span class="icon">🏃</span>
          <span class="text">Logout</span>
        </RouterLink>
      </div>
    </nav>
  </header>
</template>

<script setup>
import { computed } from 'vue'
import { useAuthStore } from '@/stores/authStore'
import { useRouter, RouterLink } from 'vue-router'

const authStore = useAuthStore()
const router = useRouter()

const isAuthenticated = localStorage.getItem('authToken')

</script>

<style scoped>

.header {
    position: sticky;
    top: 0;
    background-color: var(--color-background);
    z-index: 100;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border-bottom: 1px solid var(--color-border);
  }
  
  .navigation {
    width: 100%;
    background-color: var(--color-background);
  }
  
  .nav-container {
    display: flex;
    align-items: center;
    gap: 1rem;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
    height: 60px;
  }
  
  .nav-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    border-radius: 6px;
    text-decoration: none;
    color: var(--color-text);
    transition: all 0.2s ease;
    border: 1px solid transparent;
  }
  
  .nav-link:hover {
    background-color: var(--color-background-soft);
  }
  
  .nav-link.router-link-exact-active {
    background-color: var(--color-background-mute);
    border-color: var(--color-border);
  }
  
  .icon {
    font-size: 1.2rem;
  }
  
  .text {
    font-size: 0.9rem;
    font-weight: 500;
  }
  
  @media (max-width: 768px) {
    .nav-container {
      padding: 0 1rem;
      justify-content: space-around;
    }
  
    .nav-link {
      padding: 0.75rem;
      flex-direction: column;
      gap: 0.25rem;
      font-size: 0.8rem;
    }
  
    .icon {
      font-size: 1.1rem;
    }
  
    .text {
      font-size: 0.75rem;
    }
  }
  </style>