<template>
  <div class="container mx-auto p-4 border rounded-xl mt-5">
    <Navbar />

    <h1 class="text-3xl font-bold mb-4">Übersicht</h1>

    <div class="grid grid-cols-3 gap-4">
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

    <!-- Balkendiagramm für Monatliche Einnahmen und Ausgaben -->
    <div class="mt-8 bg-white p-6 rounded-lg shadow border">
      <h2 class="text-2xl font-bold mb-4 text-black">Monatliche Einnahmen & Ausgaben</h2>
      <BarChart :income="monthlyIncome ?? {}" :expense="monthlyExpense ?? {}" />
    </div>

    <!-- Liniendiagramm für Ausgaben -->
    <div class="bg-white shadow-md rounded-lg p-4 mb-6 border mt-4">
      <h2 class="text-lg font-semibold mb-2 text-black">Ausgaben über Zeit</h2>
      <LineChart v-if="expenses.length" :expenses="expenses" />
      <p v-else class="text-gray-500">Keine Daten verfügbar</p>
    </div>

  </div>
</template>

<script setup>
  import { defineProps, ref, onMounted } from 'vue'
  import Navbar from '@/Components/Navbar.vue'
  import BarChart from '@/Components/BarChart.vue'
  import { Chart, registerables } from 'chart.js'
  import LineChart from '@/Components/LineChart.vue'

  // Chart.js registrieren
  Chart.register(...registerables)

  // Daten für die Tabelle & das Diagramm
  const expenses = ref([])

  // Daten vom Backend abrufen
  const fetchExpenses = async () => {
    try {
        const response = await fetch('/dashboard/expenses')
        expenses.value = await response.json()
      } catch (error) {
        console.error('Fehler beim Laden der Ausgaben:', error)
      }
  }

  // Hier `defineProps()` verwenden!
  const props = defineProps({
    totalIncome: Number,
    totalExpense: Number,
    balance: Number,
    monthlyIncome: Object,
    monthlyExpense: Object,
    routes: Object,
  })

  // API beim Start laden
  onMounted(fetchExpenses)
</script>
