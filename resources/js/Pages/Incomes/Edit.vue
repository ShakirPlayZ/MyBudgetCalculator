<template>
  <TransitionRoot appear :show="isOpen" as="template">
    <Dialog as="div" @close="">
      <div class="fixed inset-0 flex items-center justify-center p-4 bg-gray-900 bg-opacity-50">
        <DialogPanel class="bg-white p-6 rounded-lg w-96">
          <DialogTitle class="text-lg font-bold">Einnahme bearbeiten</DialogTitle>
          <div class="flex justify-end mt-4">
            <div class="container mx-auto p-4 border-2 border-solid rounded-xs mt-5">

              <form @submit.prevent="submit">
                <div class="mb-4">
                  <label class="block">Quelle:</label>
                  <input v-model="form.source" type="text" class="border p-2 w-full" required>
                </div>
          
                <div class="mb-4">
                  <label class="block">Betrag (€):</label>
                  <input v-model="form.amount" type="number" step="0.01" class="border p-2 w-full" required>
                </div>
          
                <div class="mb-4">
                  <label class="block">Datum:</label>
                  <input v-model="form.received_at" type="date" class="border p-2 w-full" required>
                </div>
          
                <div class="mb-4">
                  <label class="block">Kategorie:</label>
                  <select v-model="form.category_id" class="border p-2 w-full">
                    <option v-for="category in props.categories" :key="category.id" :value="category.id">
                      {{ category.name }}
                    </option>
                  </select>
                </div>
          
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Speichern</button>
                <Link href="/incomes" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded">Abbrechen</Link>
              </form>

              <p v-if="form.errors.source" class="text-red-500">{{ form.errors.source }}</p>
              <p v-if="form.errors.amount" class="text-red-500">{{ form.errors.amount }}</p>
              <p v-if="form.errors.received_at" class="text-red-500">{{ form.errors.received_at }}</p>
            </div>

          </div>
        </DialogPanel>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
  
  <script setup>
    import { ref } from 'vue'
    import { Link, useForm } from '@inertiajs/vue3'
    import { Dialog, DialogPanel, DialogTitle, TransitionRoot } from '@headlessui/vue'

    const isOpen = ref(true)
    
    const props = defineProps({ income: Object, categories: Array })
    
    const form = useForm({
        source: props.income.source,
        amount: props.income.amount,
        received_at: props.income.received_at,
        category_id: props.income.category_id
    })
    
    const submit = () => {
        form.put(`/incomes/update/${props.income.id}`)
    }
  </script>
  