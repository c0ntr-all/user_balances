<script setup lang="ts">
interface TableRow {
  id: number
  amount: number
  created_at: string
  description: string
  event_type: string
}

const props = defineProps<{
  data: TableRow,
}>()

const getOperationIcon = (type: string) => {
  if (type === 'balance_credited') {
    return '+'
  }
  if (type === 'balance_debited') {
    return '-'
  }

  return '0'
}
</script>

<template>
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th>#</th>
          <th>Type</th>
          <th>Amount</th>
          <th>Description</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(tr) in data"
          :key="tr.id"
        >
          <td></td>
          <td>{{ getOperationIcon(tr.type) }}</td>
          <td>{{ tr.amount }}</td>
          <td>{{ tr.description }}</td>
          <td>{{ tr.created_at }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
