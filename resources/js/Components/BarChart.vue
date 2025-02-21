<template>
  <div>
    <canvas ref="chartCanvas"></canvas>
  </div>
</template>

<script setup>
  import { ref, onMounted, watch } from 'vue'
  import Chart from 'chart.js/auto'

  // Hilfsfunktion zur Umwandlung von Monatsnummern in Namen
  const getMonthName = (monthNumber) => {
    const months = [
      'Januar', 'Februar', 'März', 'April', 'Mai', 'Juni',
      'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'
    ]
    return months[monthNumber - 1] // -1, weil Monate bei 0 beginnen
  }

  // Props für Einnahmen/Ausgaben pro Monat ODER einzelne Ausgaben mit Datum
  const props = defineProps({
    income: Object,   // Einnahmen nach Monat
    expense: Object,  // Ausgaben nach Monat
    expenses: Array   // Einzelne Ausgaben mit Datum
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

    // Prüfen, ob Einnahmen/Ausgaben ODER einzelne Ausgaben angezeigt werden sollen
    if (props.income && props.expense) {
      // Standard-Anzeige: Einnahmen & Ausgaben pro Monat
      chartInstance = new Chart(chartCanvas.value, {
        type: 'bar',
        data: {
          labels: Object.keys(props.income).map(month => getMonthName(parseInt(month))),
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
          plugins: { legend: { position: 'top' } },
          scales: {
            x: { title: { display: true, text: 'Monate' } },
            y: { title: { display: true, text: 'Betrag (€)' } }
          }
        }
      })
    } else if (props.expenses) {
      // Neue Anzeige: Einzelne Ausgaben mit Datum
      const labels = props.expenses.map(expense => expense.paid_at)
      const dataValues = props.expenses.map(expense => expense.amount)

      chartInstance = new Chart(chartCanvas.value, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [
            {
              label: 'Ausgaben',
              backgroundColor: 'rgba(255, 99, 132, 0.6)',
              borderColor: 'rgba(255, 99, 132, 1)',
              borderWidth: 1,
              data: dataValues
            }
          ]
        },
        options: {
          responsive: true,
          plugins: { legend: { position: 'top' } },
          scales: {
            x: { title: { display: true, text: 'Datum' } },
            y: { title: { display: true, text: 'Betrag (€)' } }
          }
        }
      })
    }
  }
</script>
