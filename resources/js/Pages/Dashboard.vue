<template>
  <div class="container mx-auto p-4 border-2 border-solid rounded-xs mt-5">
    <Navbar />

    <h1 class="text-3xl font-bold mb-4">Übersicht</h1>

    <div class="grid grid-cols-3 gap-4 text-white">
      <div class="p-6 bg-green-500 rounded-lg shadow">
        <h2 class="text-lg">Gesamteinnahmen</h2>
        <p class="text-2xl font-bold">{{ (props.totalIncome ?? 0).toFixed(2) }} €</p>
      </div>
      <div class="p-6 bg-red-500 rounded-lg shadow">
        <h2 class="text-lg">Gesamtausgaben</h2>
        <p class="text-2xl font-bold">{{ (props.totalExpense ?? 0).toFixed(2) }} €</p>
      </div>
      <div class="p-6 bg-blue-500 rounded-lg shadow">
        <h2 class="text-lg">Aktuelles Budget</h2>
        <p class="text-2xl font-bold">{{ (props.balance ?? 0).toFixed(2) }} €</p>
      </div>
    </div>

    <div class="mt-8 bg-white p-6 rounded-lg shadow">
      <h2 class="text-2xl font-bold mb-4">Monatliche Einnahmen & Ausgaben</h2>
      <BarChart :income="monthlyIncome ?? {}" :expense="monthlyExpense ?? {}" />
    </div>
  </div>
</template>

<script setup>
  import { defineProps } from 'vue'
  import Navbar from '@/Components/Navbar.vue'
  import BarChart from '@/Components/BarChart.vue'

  // 🛠️ Hier `defineProps()` verwenden!
  const props = defineProps({
    totalIncome: Number,
    totalExpense: Number,
    balance: Number,
    monthlyIncome: Object,
    monthlyExpense: Object,
    routes: Object,
  })
</script>
