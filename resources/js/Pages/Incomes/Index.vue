<template>
    <div>

      <h1 class="text-2xl font-bold mb-4">Einnahmen</h1>
      <Link :href="'/incomes/create'" class="btn btn-primary text-white rounded">+ Neue Einnahme</Link>

      <!-- Sucheingabe -->
      <input 
        v-model="search"
        placeholder="🔍 Suche..."
        class="mt-4 p-2 border rounded w-full"
      />

      <!-- Datatable -->
      <EasyDataTable
        :headers="headers"
        :items="props.incomes"
        show-index
        :search-value="search"
        class="border shadow-lg w-full"
        :rows-per-page="5"
      >
        <!-- Slot für die Betrag-Spalte -->
        <template #item-amount="{ amount }">
          <div>{{ amount.toLocaleString("de-DE", { style: "currency", currency: "EUR" }) }}</div>
        </template>

        <!-- Slot für die "Aktionen"-Spalte -->
        <template #item-actions="{ amount, id }">
          <Link :href="`/incomes/${id}/edit`" class="btn btn-xs btn-outline btn-error ml-2">✏️ Bearbeiten</Link>
          <button class="btn btn-xs btn-outline btn-error ml-2" @click="deleteIncome(id)">🗑️ Löschen</button>
        </template>
      </EasyDataTable>

    </div>
  </template>
  
  <script setup>
    import { ref, defineProps } from 'vue'
    import { Link, useForm } from '@inertiajs/vue3'
    import EasyDataTable from 'vue3-easy-data-table'
    import 'vue3-easy-data-table/dist/style.css'
    import DefaultLayout from '@/Layouts/DefaultLayout.vue'

    defineOptions({
      layout: DefaultLayout
    })

    // Spaltenüberschriften
    const headers = [
      { text: "Betrag", value: "amount", sortable: true },
      { text: "Name", value: "source", sortable: true },
      { text: "Datum", value: "received_at", sortable: true },
      { text: "Aktionen", value: "actions", sortable: false, width: 300 }
    ]

    const search = ref("")
    const props = defineProps({ incomes: { type: Array, default: () => [] }, routes: Object, })
    const form = useForm({})

    const deleteIncome = (id) => {
        if (confirm('Diese Einnahme wirklich löschen?')) {
          form.delete(`/incomes/${id}`)
            .then(() => {
              incomes.value = incomes.value.filter(income => income.id !== id)
              console.log("Einnahme gelöscht!")
            })
            .catch(error => {
              console.error("Fehler beim Löschen:", error)
            })
        }
    }
  </script>
  