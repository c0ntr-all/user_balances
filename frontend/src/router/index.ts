import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router'
import MainView from '../views/MainView.vue'

const routes: RouteRecordRaw[] = [{
  path: '/',
  name: 'main',
  component: MainView,
  meta: {
    title: 'Главная',
    is_menu: true
  },
}, {
  path: '/operations-history',
  name: 'operations-history',
  component: () => import('../views/OperationsHistoryView.vue'),
  meta: {
    title: 'История операций',
    is_menu: true
  },
}, {
  path: '/login',
  component: () => import('../views/LoginView.vue'),
  meta: {
    title: 'Login',
    is_menu: false
  },
  name: 'login',
  alias: '/login'
}, {
  path: '/:catchAll(.*)*',
  component: () => import('../views/NotFoundView.vue')
}]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: routes
})

export default router
