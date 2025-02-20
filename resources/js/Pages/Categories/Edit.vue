<template>
    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="">
            <div class="fixed inset-0 flex items-center justify-center p-4 bg-gray-900 bg-opacity-50">
                <DialogPanel class="bg-white p-6 rounded-lg w-96">
                    <DialogTitle class="text-lg font-bold">Kategorie bearbeiten</DialogTitle>
                    <div class="flex justify-end mt-4">

                        <form @submit.prevent="submit" class="space-y-2">
                            <input v-model="form.name" type="text" placeholder="Kategoriename" required class="border p-2 rounded w-full">
                            <select v-model="form.type" class="border p-2 rounded w-full">
                                <option value="income">Einnahme</option>
                                <option value="expense">Ausgabe</option>
                            </select>

                            <div class="flex space-x-2">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Speichern</button>
                                <button @click.prevent="router.visit('/categories')" class="bg-gray-500 text-white px-4 py-2 rounded">Abbrechen</button>
                            </div>
                        </form>

                    </div>
                </DialogPanel>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
    import { ref, defineProps } from 'vue'
    import { router } from '@inertiajs/vue3'
    import { Dialog, DialogPanel, DialogTitle, TransitionRoot } from '@headlessui/vue'

    const isOpen = ref(true)
    const props = defineProps({
        category: Object
    })

    const form = ref({
        name: props.category.name || '',
        type: props.category.type || 'expense'
    })

    const submit = () => {
        router.put(`/categories/${props.category.id}`, form.value, {
            preserveState: true,
            onSuccess: () => router.visit('/categories')
        })
    }
</script>