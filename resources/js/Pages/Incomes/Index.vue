<template>
    <div class="container mx-auto p-4 border-2 border-solid rounded-xs mt-5">
      <Navbar />

      <h1 class="text-2xl font-bold mb-4">Einnahmen</h1>
      <Link :href="'/incomes/create'" class="px-4 py-2 bg-green-500 text-white rounded">+ Neue Einnahme</Link>

      <table class="w-full mt-4 border-collapse border border-gray-300 table">
        <thead>
          <tr class="bg-gray-200">
            <th class="border px-4 py-2">Quelle</th>
            <th class="border px-4 py-2">Betrag</th>
            <th class="border px-4 py-2">Datum</th>
            <th class="border px-4 py-2">Aktionen</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="income in props.incomes" :key="income.id" class="text-center">
            <td class="border px-4 py-2">{{ income.source }}</td>
            <td class="border px-4 py-2">{{ income.amount.toFixed(2) }} €</td>
            <td class="border px-4 py-2">{{ income.received_at }}</td>
            <td class="border px-4 py-2">
              <Link :href="`/incomes/${income.id}/edit`" class="text-blue-500">✏️ Bearbeiten</Link> |
              <button @click="deleteIncome(income.id)" class="text-red-500">🗑️ Löschen</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script setup>
    import { defineProps } from 'vue'
    import { Link, useForm } from '@inertiajs/vue3'
    import Navbar from '@/Components/Navbar.vue'
    
    const props = defineProps({ incomes: Array, routes: Object, })
    const form = useForm({})
    const deleteIncome = (id) => {
        if (confirm('Diese Einnahme wirklich löschen?')) {
        form.delete(route('incomes.destroy', id))
        }
    }
  </script>
  