<template>

  <TopMenu :key="menuKey"/>

  <main class="content">
    <RouterView />
  </main>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue'
import { useAuthStore } from '@/stores/authStore'
import { useRoute, useRouter } from 'vue-router';
import TopMenu from '@/components/Menu/TopMenu.vue';

const authStore = useAuthStore()
const menuKey = ref(0)
const router = useRouter()
const route = useRoute()


onMounted(() => {
  authStore.checkAuth()
});

watch(() => route.path, () => {
  menuKey.value++
})

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

.content {
  max-width: 1200px;
  margin: 2rem auto;
  padding: 0 2rem;
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