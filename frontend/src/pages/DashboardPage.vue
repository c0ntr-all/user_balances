<script setup lang="ts">
import { onBeforeUnmount, onMounted, ref } from 'vue'
import api from '@/utils/api.ts'
import OperationsHistoryTable from '@/components/OperationsHistoryTable.vue'
import { useUserStore } from '@/stores/modules/user.ts'

const user = useUserStore()
const operationsHistory = ref({})
const loading = ref(true)
const timeout = 10000
let intervalId: number | null = null

const getOperationsHistory = async () => {
  await api.get('user/operations?&limit=5')
    .then(response => {
      operationsHistory.value = response.data.operations.data
      user.$patch({
        balance: response.data.balance
      })
    }).catch(error => {
    }).finally(() => {
      loading.value = false
    })
}

onMounted(() => {
  getOperationsHistory()
  intervalId = setInterval(() => {
    getOperationsHistory()
  }, timeout)
})
onBeforeUnmount(() => {
  if (intervalId !== null) {
    clearInterval(intervalId)
  }
})
</script>

<template>
  <div class="row">
    <div class="col-lg-12">
      <p>Баланс пользователя: <b>{{ user.balance }}</b></p>
    </div>
    <div class="col-lg-6">
      <p>5 последний операций:</p>
    </div>
    <div class="col-lg-12">
      <div v-if="loading">
        Loading...
      </div>
      <OperationsHistoryTable
        v-else
        :data="operationsHistory"
      />
    </div>
  </div>
</template>
