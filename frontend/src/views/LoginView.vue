<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useUserStore } from '@/stores/modules/user'

interface ErrorResponse {
  response: {
    data: {
      message: string;
    }
  }
}

const $router = useRouter()
const user = useUserStore()

const email = ref('')
const password = ref('')
const login = (): void => {
  user.login({
    email: email.value,
    password: password.value
  }).then((): void => {
    $router.push('/')
  }).catch((error: ErrorResponse): void => {
    alert(error.response.data.message)
  })
}
</script>

<template>
  <div class="text-center">
    <form
      @submit.prevent="login"
      class="form-signin"
    >
      <img class="mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
      <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

      <div class="form-floating">
        <input
          v-model="email"
          type="email"
          class="form-control"
          placeholder="name@example.com"
        >
        <label for="floatingInput">Email address</label>
      </div>
      <div class="form-floating">
        <input
          v-model="password"
          type="password"
          class="form-control"
          id="floatingPassword"
          placeholder="Password"
        >
        <label for="floatingPassword">Password</label>
      </div>

      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
    </form>
  </div>
</template>

<style scoped lang="scss">
.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: auto;
}
</style>
