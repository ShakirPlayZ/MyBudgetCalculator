<template>
    <div class="bg-gray-900 text-white rounded-md shadow">
      
      <!-- Obere Leiste mit Logo und Hamburger-Menü -->
      <div class="flex justify-between items-center p-4">
        <!-- App-Logo -->
        <Link href="/dashboard">
          <h1 class="text-xl font-bold hover:text-red-500">Haushaltsrechner</h1>
        </Link>
  
        <!-- Hamburger Menü Button für Mobilgeräte -->
        <button @click="toggleMenu" class="md:hidden text-xl">
          <i class="pi pi-bars"></i>
        </button>
      </div>
  
      <!-- Navigation für größere Bildschirme -->
      <nav class="hidden md:flex justify-between p-4">
        <div class="space-x-4">
          <Link href="/dashboard" class="hover:text-red-500"><i class="pi pi-home"></i> Dashboard</Link>
          <Link href="/categories" class="hover:text-red-500"><i class="pi pi-book"></i> Kategorien</Link>
          <Link href="/incomes" class="hover:text-red-500"><i class="pi pi-euro"></i> Einnahmen</Link>
          <Link href="/expenses" class="hover:text-red-500"><i class="pi pi-shopping-cart"></i> Ausgaben</Link>
        </div>
  
        <!-- Theme-Wechsel für größere Bildschirme -->
        <div class="dropdown dropdown-right z-10">
          <label tabindex="0" class="btn btn-ghost m-1 hover:text-red-500">
            <i class="pi pi-sliders-v"></i> Theme Farbe
          </label>
          <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-gray-600 rounded-box w-52">
            <li v-for="theme in themes" :key="theme">
              <a class="capitalize" @click="changeTheme(theme)">{{ theme }}</a>
            </li>
          </ul>
        </div>
      </nav>
  
      <!-- Mobiles Dropdown-Menü (nur sichtbar wenn menuOpen = true) -->
      <div v-if="menuOpen" class="md:hidden bg-gray-800 text-white p-4 rounded-md shadow-md">
        <Link href="/dashboard" class="block py-2 hover:text-red-500" @click="toggleMenu"><i class="pi pi-home"></i> Dashboard</Link>
        <Link href="/categories" class="block py-2 hover:text-red-500" @click="toggleMenu"><i class="pi pi-book"></i> Kategorien</Link>
        <Link href="/incomes" class="block py-2 hover:text-red-500" @click="toggleMenu"><i class="pi pi-euro"></i> Einnahmen</Link>
        <Link href="/expenses" class="block py-2 hover:text-red-500" @click="toggleMenu"><i class="pi pi-shopping-cart"></i> Ausgaben</Link>
  
        <!-- Theme-Wechsel für Mobilgeräte -->
        <div class="dropdown w-full mt-4 z-10">
          <label tabindex="0" class="btn btn-ghost w-full text-left hover:text-red-500">
            <i class="pi pi-sliders-v"></i> Theme Farbe
          </label>
          <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-gray-600 rounded-box w-52">
            <li v-for="theme in themes" :key="theme">
              <a class="capitalize" @click="changeTheme(theme)">{{ theme }}</a>
            </li>
          </ul>
        </div>
      </div>
  
    </div>
</template>
  
<script setup>
  import { ref, onMounted } from 'vue'
  import { Link } from '@inertiajs/vue3'
  
  // Zustand für das mobile Menü
  const menuOpen = ref(false)
  
  const toggleMenu = () => {
    menuOpen.value = !menuOpen.value
  }
  
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
  