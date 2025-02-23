import './bootstrap';
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import 'primeicons/primeicons.css'

createInertiaApp({
  resolve: async name => {
    const pages = import.meta.glob('./Pages/**/*.vue') // Alle Vue-Seiten laden
    const importPage = pages[`./Pages/${name.replace('.', '/')}.vue`]

    if (!importPage) {
      throw new Error(`Seite ${name} wurde nicht gefunden!`)
    }

    return importPage() // WICHTIG: `importPage` aufrufen, damit die Promise aufgelöst wird
  },
  setup({ el, App, props }) {
    createApp({ render: () => h(App, props) }).mount(el)
  },
})
