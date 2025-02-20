<template>
    <div>
        <canvas ref="chartCanvas"></canvas>
    </div>
</template>

<script setup>
    import { ref, onMounted, watch } from 'vue'
    import Chart from 'chart.js/auto'
    import 'chartjs-adapter-date-fns'

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

        // Punkte-Daten vorbereiten (X = Datum, Y = Betrag)
        const scatterData = props.expenses.map(expense => ({
            x: new Date(expense.paid_at), // Datum als X-Wert
            y: expense.amount // Betrag als Y-Wert
    }))

    chartInstance = new Chart(chartCanvas.value, {
        type: 'scatter',
        data: {
            datasets: [
                {
                    label: 'Ausgaben',
                    data: scatterData,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    pointRadius: 7
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } },
            scales: {
                x: {
                type: 'time',
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
