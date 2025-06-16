import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '@/pages/LoginView.vue'
import DashboardView from '@/pages/DashboardView.vue'

const routes = [
  {
    path: '/login',
    name: 'LoginView',
    component: LoginView,
  },
  {
    path: '/',
    name: 'DashboardView',
    component: DashboardView,
    meta: {
      requiresAuth: true,
    },
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, from, next) => {
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth)
  const token = localStorage.getItem('token');

  if (requiresAuth && !token) {
    return next({ name: 'LoginView' })
  } 

  if (!requiresAuth && token) {
    return next({ name: 'DashboardView' })
  }

  next()
})

export default router
