<template>
    <div>
        <h1 class="text-2xl font-bold mb-4">Kategorien verwalten</h1>
        <button @click="openQuickView('Neue Kategorie')" class="btn btn-primary rounded">+ Neue Kategorie</button>

        <!-- Sucheingabe -->
        <input 
        v-model="search"
        placeholder="Suche..."
        class="mt-4 p-2 border rounded w-full"
        />

        <!-- Kartenansicht (nur auf kleinen Bildschirmen sichtbar) -->
        <div class="block sm:hidden space-y-4">
            <div v-for="category in filteredCategories" :key="category.id" class="border p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-bold">{{ category.name }}</h3>
                <p class="text-sm">{{ category.type === 'income' ? 'Einnahme' : 'Ausgabe' }}</p>

                <!-- Aktionen -->
                <div class="mt-3 flex space-x-2">
                <button @click="editCategory(category)" class="btn btn-sm btn-outline btn-primary">
                    <i class="pi pi-pencil"></i> Bearbeiten
                </button>
                <button @click="deleteCategory(category.id)" class="btn btn-sm btn-outline btn-error">
                    <i class="pi pi-trash"></i> Löschen
                </button>
                </div>
            </div>
        </div>

        <!-- Table auf kleinen Geräten ausblenden -->
        <div class="hidden sm:block">
            <!-- Datatable -->
            <EasyDataTable
                v-model:rows-per-page="rowsPerPage"
                :headers="headers"
                :items="filteredCategories"
                show-index
                :search-value="search"
                class="border shadow-lg w-full"
                :rows-per-page="5"
                :sort-by="sortBy"
                :sort-type="sortType"
            >
                <template v-slot:item="{ item, column }">
                    <!-- Slot für die "Typ"-Spalte -->
                    <template v-if="column === 'name'">
                        <div>{{ item.name }}</div>
                    </template>

                    <!-- Slot für die "Typ"-Spalte -->
                    <template v-if="column === 'type'">
                        <div>{{ item.type === 'income' ? 'Einnahme' : 'Ausgabe' }}</div>
                    </template>

                    <!-- Slot für die "Aktionen"-Spalte -->
                    <template v-if="column === 'actions'">
                        <button @click="editCategory(item)" class="btn btn-xs btn-outline btn-error ml-2"><i class="pi pi-pencil"></i> Bearbeiten</button>
                        <button class="btn btn-xs btn-outline btn-error ml-2" @click="deleteCategory(item.id)"><i class="pi pi-trash"></i> Löschen</button>
                    </template>
                </template>
            </EasyDataTable>
        </div>

        <!-- QuickView für Erstellen/Bearbeiten -->
        <QuickView :isOpen="quickViewOpen" :title="quickViewTitle" @close="quickViewOpen = false">
            <form @submit.prevent="submit">
                <input v-model="form.name" type="text" placeholder="Name" required class="border p-2 rounded w-full mb-2">

                <label class="text-black">Typ:</label>
                <select v-model="form.type" class="border p-2 rounded w-full mb-2">
                    <option value="income">Einnahme</option>
                    <option value="expense">Ausgabe</option>
                </select>

                <button type="submit" class="btn btn-primary w-full rounded"><i class="pi pi-save"></i> {{ editingCategory ? 'Aktualisieren' : 'Speichern' }}</button>
            </form>
        </QuickView>

    </div>
</template>

<script setup>
    import { ref, defineProps, watch, computed } from 'vue'
    import { router } from '@inertiajs/vue3'
    import EasyDataTable from 'vue3-easy-data-table'
    import 'vue3-easy-data-table/dist/style.css'
    import DefaultLayout from '@/Layouts/DefaultLayout.vue'
    import QuickView from '@/Components/QuickView.vue'

    defineOptions({
    layout: DefaultLayout
    })

    // Spaltenüberschriften
    const headers = [
      { text: "Name", value: "name", sortable: true },
      { text: "Typ", value: "type", sortable: true },
      { text: "Aktionen", value: "actions", sortable: false, width: 300 }
    ]

    const search = ref("")
    const defaultRows = 25
    const sortBy = "type";
    const sortType = "desc";

    const props = defineProps({
        categories: Array,
        routes: Object,
    })

    const filteredCategories = computed(() => {
      return props.categories.filter(category => {
        const name = category.name ? category.name.toLowerCase() : '';
        const type = category.type ? category.type.toLowerCase() : '';

        return name.includes(search.value.toLowerCase()) ||
            type.includes(search.value.toLowerCase());
      });
    });

    // Prüfen, ob ein Wert in LocalStorage gespeichert wurde, sonst nutze 25 als Standard
    const rowsPerPage = ref(Number(localStorage.getItem('rowsPerPage')) || defaultRows)

    // Beobachte Änderungen an `rowsPerPage` und speichere sie in LocalStorage
    watch(rowsPerPage, (newValue) => {
        localStorage.setItem('rowsPerPage', newValue)
    })

    const quickViewOpen = ref(false)
    const quickViewTitle = ref('')
    const form = ref({ name: '', type: '' })
    const editingCategory = ref(null)

    const openQuickView = (title) => {
      quickViewTitle.value = title
      form.value = { name: '', type: '' }
      editingCategory.value = null
      quickViewOpen.value = true
    }

    const editCategory = (category) => {
      quickViewTitle.value = 'Kategorie bearbeiten'
      form.value = { ...category }
      editingCategory.value = category.id
      quickViewOpen.value = true
    }

    const submit = () => {
      if (editingCategory.value) {
        router.put(`/categories/${editingCategory.value}`, form.value, {
          onSuccess: () => quickViewOpen.value = false
        })
      } else {
        router.post('/categories', form.value, {
          onSuccess: () => quickViewOpen.value = false
        })
      }
    }

    const deleteCategory = (id) => {
        if (confirm('Diese Kategorie wirklich löschen?')) {
            router.delete(`/categories/${id}`, {
            onSuccess: () => console.log('Kategorie gelöscht!')
          })
        }
    }
</script>