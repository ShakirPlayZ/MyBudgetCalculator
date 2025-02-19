<template>
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <h1 class="text-3xl font-bold">{{ message }}</h1>
    </div>
</template>
  
<script setup>
    defineProps({ message: String });
</script>
