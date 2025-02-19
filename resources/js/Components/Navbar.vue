    <template>
        <nav class="bg-gray-800 text-white p-4 flex justify-between rounded-md mb-5">
            <h1 class="text-xl font-bold">💰 Haushaltsrechner</h1>
            <div class="space-x-4">
                <Link href="/dashboard" class="hover:underline">Dashboard</Link>
                <Link href="/incomes" class="hover:underline">Einnahmen</Link>
                <Link href="/expenses" class="hover:underline">Ausgaben</Link>
            </div>
        </nav>
    </template>
  
  <script setup>
    import { Link } from '@inertiajs/vue3'
    defineProps({ routes: Object })
  </script>
  