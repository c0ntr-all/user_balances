<script setup lang="ts">
import { onMounted, ref } from 'vue'
import api from '@/utils/api.ts'
import OperationsHistoryTable from '@/components/OperationsHistoryTable.vue'

interface IGetOperationsHistoryApiResponse {

}

const operationsHistory = ref({})
const loading = ref(true)
const search = ref('')

const getOperationsHistory = async (search: string = '') => {
  await api.get(`user/operations?&search=${search}`)
    .then(response => {
      operationsHistory.value = response.data.operations.data
    }).catch(error => {
    }).finally(() => {
      loading.value = false
    })
}

const processSearch = async () => {
  loading.value = true
  await getOperationsHistory(search.value)
}

onMounted(() => {
  getOperationsHistory()
})
</script>

<template>
  <div class="row">
    <div class="col-lg-6 mb-3">
      <form @submit.prevent="processSearch">
        <input
          v-model="search"
          type="text"
          class="form-control"
          placeholder="Search by description..."
        >
      </form>
    </div>
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
</template>
