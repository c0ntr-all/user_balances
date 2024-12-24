<script setup lang="ts">
import { ref } from 'vue'

const balance = ref(0)
</script>

<template>
  Баланс пользователя: {{ balance }}
</template>
