import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import './style.css'
import router from './router/index.ts'
import { useAuthStore } from './stores/auth.ts'

const app = createApp(App)

const pinia = createPinia()
app.use(pinia)
app.use(router)

const authStore = useAuthStore(pinia)

await authStore.initializeAuth()

app.mount('#app')