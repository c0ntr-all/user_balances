import { defineStore, type StoreDefinition } from 'pinia'
import api from '@/utils/api'

interface AuthData {
  email: string,
  password: string
}

interface User {
  name: string
  email: string
  balance: number
}

interface AuthResponse {
  data: {
    access_token: string
    user: User
  }
}

export const useUserStore: StoreDefinition = defineStore('user', {
  state: () => ({
    name: '',
    email: '',
    balance: 0
  }),
  actions: {
    async login(data: AuthData): Promise<void> {
      await api.post('/login', data)
        .then((response: AuthResponse) => {
          localStorage.setItem('access_token', response.data.access_token)

          const user = response.data.user

          this.$patch({
            name: user.name,
            email: user.email,
            balance: user.balance
          })

          return response
        }).catch(error => {
          localStorage.removeItem('access_token')
          throw error
        })
    },
    async logout(): Promise<void> {
      await api.post('user/logout')
        .then(() => {
          localStorage.removeItem('access_token')

          this.$patch({
            user: ''
          })
        })
    },
    async refreshProfile(): Promise<void> {
      await api.get('user')
        .then(response => {
          const user = response.data

          this.$patch({
            name: user.name,
            email: user.email,
            balance: user.balance
          })
        }).catch(error => {

        })
    }
  },
  getters: {
    isLoggedIn() {
      return !!localStorage.getItem('access_token')
    }
  }
})
