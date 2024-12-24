<script setup lang="ts">
import { RouterLink, RouterView, useRouter, type RouteRecordRaw } from 'vue-router'
import { computed } from 'vue'
import MainView from '@/views/MainView.vue'

const $router = useRouter()

const NoRouteTitle = 'No Route'
const noRoute = {
  path: '/',
  name: 'main',
  component: MainView,
  meta: {
    title: NoRouteTitle,
    is_menu: true
  },
}
const routes = $router.getRoutes()
const menuItems = computed((): RouteRecordRaw[] => {
  if (routes.length > 0) {
    return routes.filter((route: RouteRecordRaw) => route.meta?.is_menu === true)
  }
  return []
})

const prepareLoginRoute = () => {
  const loginRoute = routes.find((route: RouteRecordRaw) => route.name === 'login')
  return loginRoute ? loginRoute : noRoute
}
const loginRoute = prepareLoginRoute()
const footerCopyright = import.meta.env.VITE_FOOTER_COPYRIGHT;
const currentYear = new Date().getFullYear()
</script>

<template>
  <div class="d-flex flex-column min-vh-100">
    <nav class="py-2 bg-light border-bottom">
      <div class="container d-flex flex-wrap">
        <ul class="nav me-auto">
          <li
            v-for="item in menuItems"
            :key="item.path"
            class="nav-item"
          >
            <router-link
              :to="item.path"
              class="nav-link link-dark px-2"
              aria-current="page"
            >
              {{ item.meta?.title }}
            </router-link>
          </li>
        </ul>
        <ul class="nav">
          <li class="nav-item">
            <router-link
              :to="loginRoute.path"
              class="nav-link link-dark px-2"
              aria-current="page"
            >
              {{ loginRoute.meta.title }}
            </router-link>
          </li>
        </ul>
      </div>
    </nav>

    <header class="py-3 mb-4 border-bottom">
      <div class="container d-flex flex-wrap justify-content-center">
        <a href="/" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none">
          <span class="fs-4">User Balances</span>
        </a>
      </div>
    </header>

    <main class="flex-grow-1">
      <div class="container">
        <RouterView/>
      </div>
    </main>

    <footer class="py-3 border-top bg-light">
      <div class="container d-flex flex-wrap justify-content-between align-items-center">
        <p class="col-md-4 mb-0 text-muted">&copy; {{ currentYear }} {{ footerCopyright }}</p>
      </div>
    </footer>
  </div>
</template>

<style scoped>
.d-flex {
  display: flex;
}

.flex-column {
  flex-direction: column;
}

.min-vh-100 {
  min-height: 100vh;
}

.flex-grow-1 {
  flex: 1;
}
</style>
