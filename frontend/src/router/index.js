import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/Auth/Login.vue'),
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../views/Auth/Register.vue'),
    },
    {
      path: '/logout',
      name: 'logout',
      component: () => import('../views/Logout/DoLogout.vue'),
    },
    {
      path: '/sales',
      name: 'sales',
      component: () => import('../views/Sales/List.vue'),
    },
    {
      path: '/saleStore',
      name: 'saleStore',
      component: () => import('../views/Sales/Form.vue'),
    },
    {
      path: '/saleEdit/:id',
      name: 'saleEdit',
      component: () => import('../views/Sales/Form.vue'),
    },
    {
      path: '/sellers',
      name: 'sellers',
      component: () => import('../views/Seller/List.vue'),
    },
    {
      path: '/sellerStore',
      name: 'sellerStore',
      component: () => import('../views/Seller/Form.vue'),
    },
    {
      path: '/sellerEdit/:id',
      name: 'sellerEdit',
      component: () => import('../views/Seller/Form.vue'),
    },
    {
      path: '/sellerSales/:id',
      name: 'sellerSales',
      component: () => import('../views/Seller/Sales.vue'),
    },
    
  ],
})

export default router
