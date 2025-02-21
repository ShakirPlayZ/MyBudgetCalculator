<template>
    <div class="container mx-auto p-4 border rounded-xl mt-5">

        <Navbar />
        <h1 class="text-2xl font-bold mb-4">Kategorien verwalten</h1>

        <!-- Sucheingabe -->
        <input 
            v-model="search"
            placeholder="🔍 Suche..."
            class="mt-4 p-2 border rounded w-full"
        />

        <!-- Datatable -->
        <EasyDataTable
            v-model:rows-per-page="rowsPerPage"
            :headers="headers"
            :items="categories"
            show-index
            :search-value="search"
            class="border shadow-lg w-full"
            :rows-per-page="5"
            :sort-by="sortBy"
            :sort-type="sortType"
        >
            <!-- Slot für die "Typ"-Spalte -->
            <template #item-type="{ type }">
                <div>{{ type === 'income' ? 'Einnahme' : 'Ausgabe' }}</div>
            </template>

            <!-- Slot für die "Aktionen"-Spalte -->
            <template #item-actions="{ amount, id }">
                <Link :href="`/categories/${id}/edit`" class="btn btn-xs btn-outline btn-error ml-2">✏️ Bearbeiten</Link>
                <button class="btn btn-xs btn-outline btn-error ml-2" @click="deleteCategory(id)">🗑️ Löschen</button>
            </template>
        </EasyDataTable>

        <!-- Neues Kategorie-Formular -->
        <div class="mt-7 p-2 border rounded shadow-lg">
            <label><b>Neue Kategorie</b></label>
            <form @submit.prevent="submit" class="mb-4 space-y-2">
                <input v-model="form.name" type="text" placeholder="Kategoriename" required class="border p-2 rounded w-full">
                <select v-model="form.type" class="border p-2 rounded w-full">
                    <option value="income">Einnahme</option>
                    <option value="expense">Ausgabe</option>
                </select>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Speichern</button>
            </form>
        </div>

    </div>
</template>

<script setup>
    import { ref, defineProps, watch } from 'vue'
    import { Link, router } from '@inertiajs/vue3'
    import Navbar from '@/Components/Navbar.vue'
    import EasyDataTable from 'vue3-easy-data-table'
    import 'vue3-easy-data-table/dist/style.css'

    const defaultRows = 25
    const sortBy = "type";
    const sortType = "desc";

    // Prüfen, ob ein Wert in LocalStorage gespeichert wurde, sonst nutze 25 als Standard
    const rowsPerPage = ref(Number(localStorage.getItem('rowsPerPage')) || defaultRows)

    // Beobachte Änderungen an `rowsPerPage` und speichere sie in LocalStorage
    watch(rowsPerPage, (newValue) => {
        localStorage.setItem('rowsPerPage', newValue)
    })

    // Spaltenüberschriften
    const headers = [
      { text: "Name", value: "name", sortable: true },
      { text: "Typ", value: "type", sortable: true },
      { text: "Aktionen", value: "actions", sortable: false, width: 300 }
    ]

    const search = ref("")

    defineProps({
        categories: Array
    })

    const form = ref({
        name: '',
        type: 'expense'
    })

    const submit = () => {
        router.post('/categories', form.value, {
            preserveScroll: true,
            onSuccess: () => form.value = { name: '', type: 'expense' }
        })
    }

    const deleteCategory = (id) => {
        if (confirm('Diese Kategorie wirklich löschen?')) {
            router.delete(`/categories/${id}`)
        }
    }
</script>