import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'MainPage',
      component: () => import('@/views/MainPageView.vue'),
    },
    {
      path: '/documents',
      name: 'Documents',
      component: () => import('@/views/DocumentView.vue'),
    },
    {
      path: '/login',
      name: 'Login',
      component: () => import('@/views/LoginView.vue'),
    },
    {
      path: '/register',
      name: 'Registration',
      component: () => import('@/views/RegistrationView.vue'),
    },
  ],
})

export default router
