<template>
  <div>

    <h1 class="text-2xl font-bold mb-4">Einnahmen</h1>
    <button @click="openQuickView('Neue Einnahme')" class="btn btn-primary rounded">+ Neue Einnahme</button>

    <!-- Sucheingabe -->
    <input 
      v-model="search"
      placeholder="Suche..."
      class="mt-4 p-2 border rounded w-full"
    />

    <!-- Datatable -->
    <EasyDataTable
      :headers="headers"
      :items="filteredIncomes"
      :search-value="search"
      class="border shadow-lg w-full"
      :rows-per-page="5"
    >
    <template v-slot:item="{ item, column }">
        <!-- Slot für die Name-Spalte -->
        <template v-if="column === 'source'">
          <div>{{ item.source }}</div>
        </template>

        <!-- Slot für die Datum-Spalte -->
        <template v-if="column === 'received_at'">
          <div>{{ formatDate(item.received_at) }}</div>
        </template>

        <!-- Slot für die Kategorie-Spalte -->
        <template v-if="column === 'category_name'">
          <div>{{ item.category_name }}</div>
        </template>

        <!-- Slot für die Betrag-Spalte -->
        <template v-if="column === 'amount'">
          <div>{{ item.amount.toLocaleString("de-DE", { style: "currency", currency: "EUR" }) }}</div>
        </template>

        <!-- Slot für die Typ-Spalte -->
        <template v-if="column === 'type'">
          <div>{{ item.type === 'recurring' ? 'Regelmäßig' : 'Einmalig' }}</div>
        </template>

        <!-- Slot für die Intervall-Spalte -->
        <template v-if="column === 'recurring_interval'">
            <div v-if="item.type === 'recurring'">
              {{ item.recurring_interval === 'weekly' ? 'Wöchentlich' : item.recurring_interval === 'monthly' ? 'Monatlich' : 'Jährlich' }}
            </div>
            <div v-else>-</div>
        </template>

        <!-- Slot für die "Aktionen"-Spalte -->
        <template v-if="column === 'actions'">
          <button @click="editIncome(item)" class="btn btn-xs btn-outline btn-error ml-2"><i class="pi pi-pencil"></i> Bearbeiten</button>
          <button class="btn btn-xs btn-outline btn-error ml-2" @click="deleteIncome(item.id)"><i class="pi pi-trash"></i> Löschen</button>
        </template>

    </template>
    </EasyDataTable>

    <!-- QuickView für Erstellen/Bearbeiten -->
    <QuickView :isOpen="quickViewOpen" :title="quickViewTitle" @close="quickViewOpen = false">
      <form @submit.prevent="submit">
        <input v-model="form.source" type="text" placeholder="Name" required class="border p-2 rounded w-full mb-2">
        <input v-model="form.amount" type="number" step="0.01" placeholder="Betrag (€)" required class="border p-2 rounded w-full mb-2">

        <label class="text-black">Eingang am:</label>
        <input v-model="form.received_at" type="date" required class="border p-2 rounded w-full mb-2">

        <label class="text-black">Kategorie:</label>
        <select v-model="form.category_id" class="border p-2 w-full mb-2" placeholder="Kategorie" required>
          <option v-for="category in categories" :key="category.id" :value="category.id">
            {{ category.name }}
          </option>
        </select>

        <label class="text-black">Typ:</label>
        <select v-model="form.type" class="border p-2 w-full mb-2" required>
            <option value="one-time">Einmalig</option>
            <option value="recurring">Regelmäßig</option>
        </select>

        <div v-if="form.type === 'recurring'">
          <label class="text-black">Wiederholung:</label>
          <select v-model="form.recurring_interval" class="border p-2 w-full mb-2">
              <option value="weekly">Wöchentlich</option>
              <option value="monthly">Monatlich</option>
              <option value="yearly">Jährlich</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary w-full rounded"><i class="pi pi-save"></i> {{ editingIncome ? 'Aktualisieren' : 'Speichern' }}</button>
      </form>
    </QuickView>

  </div>
</template>
  
<script setup>
    import { ref, defineProps, computed } from 'vue'
    import { Link, useForm, router } from '@inertiajs/vue3'
    import EasyDataTable from 'vue3-easy-data-table'
    import 'vue3-easy-data-table/dist/style.css'
    import DefaultLayout from '@/Layouts/DefaultLayout.vue'
    import QuickView from '@/Components/QuickView.vue'

    defineOptions({
      layout: DefaultLayout
    })

    // Spaltenüberschriften
    const headers = [
      { text: "Betrag", value: "amount", sortable: true },
      { text: "Name", value: "source", sortable: true },
      { text: "Datum", value: "received_at", sortable: true },
      { text: "Kategorie", value: "category_name", sortable: true },
      { text: "Typ", value: "type", sortable: true },
      { text: "Intervall", value: "recurring_interval", sortable: true },
      { text: "Aktionen", value: "actions", sortable: false, width: 300 }
    ]

    const search = ref("")
    const props = defineProps({ incomes: { type: Array, default: () => [] }, routes: Object, categories: Array })

    const filteredIncomes = computed(() => {
      return props.incomes.filter(income => {
        const description = income.description ? income.description.toLowerCase() : '';
        const category = income.category_name ? income.category_name.toLowerCase() : '';
        const amount = income.amount ? income.amount.toString() : '';

        return description.includes(search.value.toLowerCase()) ||
          category.includes(search.value.toLowerCase()) ||
          amount.includes(search.value);
      });
    });


    const formatDate = (dateString) => {
      if (!dateString) return '-'
      return new Intl.DateTimeFormat('de-DE').format(new Date(dateString))
    }

    const quickViewOpen = ref(false)
    const quickViewTitle = ref('')
    const categories = ref(props.categories)
    const form = ref({ source: '', amount: '', received_at: '', type: 'one-time', recurring_interval: 'monthly', category_id: '' })
    const editingIncome = ref(null)

    const openQuickView = (title) => {
      quickViewTitle.value = title
      form.value = { source: '', amount: '', received_at: '', type: 'one-time', recurring_interval: 'monthly', category_id: '' }
      editingIncome.value = null
      quickViewOpen.value = true
    }

    const editIncome = (income) => {
      quickViewTitle.value = 'Einnahme bearbeiten'
      form.value = { ...income }
      editingIncome.value = income.id
      quickViewOpen.value = true
    }

    const submit = () => {
      if (editingIncome.value) {
        router.put(`/incomes/${editingIncome.value}`, form.value, {
          onSuccess: () => quickViewOpen.value = false
        })
      } else {
        router.post('/incomes', form.value, {
          onSuccess: () => quickViewOpen.value = false
        })
      }
    }

    const deleteIncome = (id) => {
        if (confirm('Diese Einnahme wirklich löschen?')) {
          router.delete(`/incomes/${id}`, {
            onSuccess: () => console.log('Einnahme gelöscht!')
          })
        }
    }
  </script>
  