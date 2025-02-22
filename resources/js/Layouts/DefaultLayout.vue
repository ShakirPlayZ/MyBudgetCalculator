<template>
    <div class="container mx-auto p-4 border rounded-xl mt-5">
        <!-- Navigation -->
        <Navbar />

        <!-- Hauptinhalt -->
        <div class="flex-1 container mx-auto p-4">
            <slot />
        </div>

        <!-- Fußbereich -->
        <Footer />
    </div>
</template>

<script setup>
    import Navbar from '@/Components/Navbar.vue'
    import Footer from '@/Components/Footer.vue'
</script>