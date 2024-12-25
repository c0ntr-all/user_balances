import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router'
import MainView from '../views/MainView.vue'

const routes: RouteRecordRaw[] = [{
  path: '/',
  name: 'main',
  component: MainView,
  redirect: '/dashboard',
  children: [{
    path: '/dashboard',
    component: () => import('../pages/DashboardPage.vue'),
    meta: {
      title: 'Главная',
      is_menu: true
    }
  }, {
    path: '/operations-history',
    name: 'operations-history',
    component: () => import('../pages/OperationsHistoryPage.vue'),
    meta: {
      title: 'История операций',
      is_menu: true
    },
  }]
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
  component: () => import('../pages/NotFoundPage.vue')
}]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: routes
})

router.beforeEach((to, from, next) => {
  document.title = `${to.meta.title}`
  if (to.name !== 'login') {
    if (!localStorage.getItem('access_token')) {
      return next({
        name: 'login'
      })
    }
  }
  if (to.name === 'login' && localStorage.getItem('access_token')) {
    return next({
      name: 'dashboard'
    })
  }

  next()
})

export default router
