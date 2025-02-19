<template>
    <TransitionRoot appear :show="isOpen" as="template">
      <Dialog as="div" @close="isOpen = false">
        <div class="fixed inset-0 flex items-center justify-center p-4 bg-gray-900 bg-opacity-50">
          <DialogPanel class="bg-white p-6 rounded-lg w-96">
            <DialogTitle class="text-lg font-bold">Einnahme bearbeiten</DialogTitle>
            <input v-model="income.amount" type="number" class="w-full mt-4 p-2 border rounded" />
            <div class="flex justify-end mt-4">
              <button @click="isOpen = false" class="px-4 py-2 bg-gray-200 rounded">Abbrechen</button>
              <button @click="saveIncome" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">Speichern</button>
            </div>
          </DialogPanel>
        </div>
      </Dialog>
    </TransitionRoot>
  </template>
  
  <script setup>
    import { ref } from 'vue'
    import { Dialog, DialogPanel, DialogTitle, TransitionRoot } from '@headlessui/vue'
    
    const isOpen = ref(false)
    const income = ref({ amount: 100 })
    const saveIncome = () => { console.log("Gespeichert:", income.value) }
  </script>
  