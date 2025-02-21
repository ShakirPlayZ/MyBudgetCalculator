<template>
    <div>
      
      <h1 class="text-2xl font-bold mb-4">Ausgaben</h1>
      <Link :href="'/expenses/create'" class="btn btn-primary text-white rounded">+ Neue Ausgabe</Link>

      <!-- Sucheingabe -->
      <input 
        v-model="search"
        placeholder="🔍 Suche..."
        class="mt-4 p-2 border rounded w-full"
      />

      <!-- Datatable -->
      <EasyDataTable
        :headers="headers"
        :items="props.expenses"
        show-index
        :search-value="search"
        class="border shadow-lg w-full"
        :rows-per-page="5"
      >
        <!-- Slot für die Betrag-Spalte -->
        <template #item-amount="{ amount }">
          <div>{{ amount.toLocaleString("de-DE", { style: "currency", currency: "EUR" }) }}</div>
        </template>

        <!-- Slot für die Typ-Spalte -->
        <template #item-type="{ type }">
          <div>{{ type === 'recurring' ? 'Regelmäßig' : 'Einmalig' }}</div>
        </template>

        <!-- Slot für die Intervall-Spalte -->
        <template #item-recurring_interval="{ type, recurring_interval }">
            <div v-if="type === 'recurring'">
              {{ recurring_interval === 'weekly' ? 'Wöchentlich' : recurring_interval === 'monthly' ? 'Monatlich' : 'Jährlich' }}
            </div>
            <div v-else>-</div>
        </template>

        <!-- Slot für die "Aktionen"-Spalte -->
        <template #item-actions="{ id }">
          <Link :href="`/expenses/${id}/edit`" class="btn btn-xs btn-outline btn-error ml-2">✏️ Bearbeiten</Link>
          <button class="btn btn-xs btn-outline btn-error ml-2" @click="deleteExpense(id)">🗑️ Löschen</button>
        </template>
      </EasyDataTable>
      
    </div>
  </template>
  
  <script setup>
    import { defineProps, ref } from 'vue'
    import { Link, useForm } from '@inertiajs/vue3'
    import EasyDataTable from 'vue3-easy-data-table'
    import 'vue3-easy-data-table/dist/style.css'
    import DefaultLayout from '@/Layouts/DefaultLayout.vue'

    defineOptions({
      layout: DefaultLayout
    })

    // Spaltenüberschriften
    const headers = [
      { text: "Beschreibung", value: "description", sortable: true },
      { text: "Typ", value: "type", sortable: true },
      { text: "Intervall", value: "recurring_interval", sortable: true },
      { text: "Betrag", value: "amount", sortable: true },
      { text: "Datum", value: "paid_at", sortable: true },
      { text: "Aktionen", value: "actions", sortable: false, width: 300 }
    ]

    const search = ref("")
    
    const props = defineProps({ expenses: Array, routes: Object, })
    
    const form = useForm({})
    
    const deleteExpense = (id) => {
      if (confirm('Diese Ausgabe wirklich löschen?')) {
        form.delete(`/expenses/${id}`)
      }
    }
  </script>
  