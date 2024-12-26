import axios, { type AxiosInstance, type AxiosRequestConfig, type AxiosResponse, type AxiosError } from 'axios'
import router from '../router/index'

const api: AxiosInstance = axios.create({ baseURL: "http://user-balances.loc/api" })

api.interceptors.request.use(
  (config: AxiosRequestConfig): AxiosRequestConfig => {
    if (localStorage.access_token) {
      config.headers = {
        ...config.headers,
        authorization: `Bearer ${localStorage.access_token}`,
      }
    }

    return config
  },
  (error: AxiosError): Promise<AxiosError> => {
    console.error('Request error:', error)
    return Promise.reject(error)
  }
)

api.interceptors.response.use(
  (response: AxiosResponse) => response,
  (error: AxiosError) => {
    if (error.response) {
      // Auth errors
      if (error.response.status === 401) {
        localStorage.removeItem('access_token')
        router.push('/login')
      }
    } else if (error.request) {
      if (error.message.includes('Network Error')) {
        alert('A network error has occurred. Please check your connection or CORS settings.')
      }
    } else {
      alert(error.message)
    }

    return Promise.reject(error)
  }
)

export default api
