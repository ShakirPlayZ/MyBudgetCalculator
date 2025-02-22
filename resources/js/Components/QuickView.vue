<template>
    <transition name="slide">
        <div v-if="isOpen" class="fixed top-0 right-0 w-96 h-full bg-white shadow-lg z-50 overflow-auto p-6">
            <button @click="close" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">✖</button>
            <h2 class="text-xl text-black font-bold mb-4">{{ title }}</h2>
            <slot />
        </div>
    </transition>
</template>

<script setup>
    import { defineProps, defineEmits } from 'vue'

    defineProps({
    isOpen: Boolean, // Steuert, ob die Sidebar sichtbar ist
    title: String // Titel der Sidebar
    })

    const emit = defineEmits(['close'])

    const close = () => {
    emit('close')
    }
</script>

<style>
    /* Animation für das QuickView-Fenster */
    .slide-enter-active, .slide-leave-active {
    transition: transform 0.3s ease-in-out;
    }
    .slide-enter-from, .slide-leave-to {
    transform: translateX(100%);
    }
</style>
  