<template>
    <div>
      <canvas ref="chartCanvas"></canvas>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, watch } from 'vue'
  import Chart from 'chart.js/auto'
  import 'chartjs-adapter-date-fns' // 🚀 Wichtig für Zeitachse!
  
  const props = defineProps({
    expenses: Array // Liste der Ausgaben (Betrag & Datum)
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
  
    // X-Achse = Datum, Y-Achse = Betrag (€)
    const lineData = props.expenses.map(expense => ({
      x: new Date(expense.paid_at), // Datum als X-Wert
      y: expense.amount, // Betrag als Y-Wert
      description: expense.description // Name der Ausgabe
    }))
  
    chartInstance = new Chart(chartCanvas.value, {
      type: 'line',
      data: {
        datasets: [
          {
            label: 'Ausgaben (€)',
            data: lineData,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(0, 0, 0, 1)',
            borderWidth: 1,
            tension: 0.4, // Weichere Kurve
            pointRadius: 9 // Punkte sichtbar machen
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'top' },
          tooltip: {
            callbacks: {
              label: (context) => {
                const dataPoint = context.raw
                return `${dataPoint.description}: ${dataPoint.y} €`
              }
            }
          }
        },
        scales: {
          x: {
            type: 'time', // 📅 Zeitachse aktivieren
            time: {
              unit: 'day',
              tooltipFormat: 'yyyy-MM-dd',
              displayFormats: {
                day: 'MMM dd'
              }
            },
            title: { display: true, text: 'Datum' }
          },
          y: {
            title: { display: true, text: 'Betrag (€)' }
          }
        }
      }
    })
  }
  </script>
  