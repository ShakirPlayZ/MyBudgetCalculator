<template>
  <div>
    <canvas ref="chartCanvas"></canvas>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import Chart from 'chart.js/auto'

const props = defineProps({
  income: Object,
  expense: Object
})

const chartCanvas = ref(null)
let chartInstance = null

onMounted(() => {
  renderChart()
})

watch(props, () => {
  renderChart()
})

const renderChart = () => {
  if (chartInstance) chartInstance.destroy()

  chartInstance = new Chart(chartCanvas.value, {
    type: 'bar',
    data: {
      labels: Object.keys(props.income).map(month => `Monat ${month}`),
      datasets: [
        {
          label: 'Einnahmen',
          backgroundColor: 'rgba(75, 192, 192, 0.6)',
          data: Object.values(props.income)
        },
        {
          label: 'Ausgaben',
          backgroundColor: 'rgba(255, 99, 132, 0.6)',
          data: Object.values(props.expense)
        }
      ]
    },
    options: {
      responsive: true,
      plugins: { legend: { position: 'top' } }
    }
  })
}
</script>
