<template>
    <div class="bg-gray-800 text-white rounded-md shadow">
        <div class="dropdown dropdown-right z-10">
            <label tabindex="0" class="btn btn-ghost m-1"><i class="pi pi-sliders-v"></i> Theme</label>
            <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-gray-600 rounded-box w-52">
                <li v-for="theme in themes" :key="theme">
                    <a class="capitalize" @click="changeTheme(theme)">{{ theme }}</a>
                </li>
            </ul>
        </div>

        <div class="dropdown dropdown-right z-9">
            <label tabindex="0" class="btn btn-ghost m-1"><i class="pi pi-user"></i> Konto</label>
            <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-gray-600 rounded-box w-52">
                <li><a @click="">Login</a></li>
                <li><a @click="">Neues Konto</a></li>
            </ul>
        </div>

        <nav class="bg-gray-800 text-white p-4 flex justify-between rounded-md mb-5">
            <Link href="/dashboard"><h1 class="text-xl font-bold"><i class="pi pi-money-bill"></i> Haushaltsrechner</h1></Link>
            <div class="space-x-4">
                <Link href="/dashboard" class="hover:underline">Dashboard</Link>
                <Link href="/categories" class="hover:underline">Kategorien</Link>
                <Link href="/incomes" class="hover:underline">Einnahmen</Link>
                <Link href="/expenses" class="hover:underline">Ausgaben</Link>
            </div>
        </nav>
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue'
    import { Link } from '@inertiajs/vue3'

    defineProps({ routes: Object })

    // Verfügbare Themes aus DaisyUI
    const themes = ["valentine", "light", "dark", "cupcake", "synthwave", "retro", "dracula"]

    const selectedTheme = ref(localStorage.getItem('theme') || 'light')

    // Theme ändern & speichern
    const changeTheme = (theme) => {
        selectedTheme.value = theme
        document.documentElement.setAttribute("data-theme", theme)
        localStorage.setItem('theme', theme)
    }

    // Beim Laden das gespeicherte Theme setzen
    onMounted(() => {
        document.documentElement.setAttribute("data-theme", selectedTheme.value)
    })
</script>
  