<template>
    <div class="container max-w-3xl mx-auto p-4 border-2 border-solid rounded-xs mt-5">
      <Navbar />
      
      <h1 class="text-2xl font-bold mb-4">Ausgaben</h1>
      <Link :href="'/expenses/create'" class="px-4 py-2 bg-red-500 text-white rounded">+ Neue Ausgabe</Link>
  
      <table class="w-full mt-4 border-collapse border border-gray-300">
        <thead>
          <tr class="bg-gray-200">
            <th class="border px-4 py-2">Beschreibung</th>
            <th class="border px-4 py-2">Betrag</th>
            <th class="border px-4 py-2">Datum</th>
            <th class="border px-4 py-2">Aktionen</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="expense in props.expenses" :key="expense.id" class="text-center">
            <td class="border px-4 py-2">{{ expense.description }}</td>
            <td class="border px-4 py-2">{{ expense.amount.toFixed(2) }} €</td>
            <td class="border px-4 py-2">{{ expense.paid_at }}</td>
            <td class="border px-4 py-2">
              <Link :href="`/expenses/${expense.id}/edit`" class="text-blue-500">✏️ Bearbeiten</Link> |
              <button @click="deleteExpense(expense.id)" class="text-red-500">🗑️ Löschen</button>
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
  
  const props = defineProps({ expenses: Array, routes: Object, })
  
  const form = useForm({})
  
  const deleteExpense = (id) => {
    if (confirm('Diese Ausgabe wirklich löschen?')) {
      form.delete(route('expenses.destroy', id))
    }
  }
  </script>
  