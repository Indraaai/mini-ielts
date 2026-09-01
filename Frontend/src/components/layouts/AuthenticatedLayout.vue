<script setup lang="ts">
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const handleLogout = async () => {
  await authStore.logoutUser()

  await router.push({
    name: 'login',
  })
}
</script>

<template>
  <div class="min-h-screen bg-gray-50">
    <header class="border-b border-gray-200 bg-white">
      <div
        class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4"
      >
        <RouterLink
          :to="{ name: 'speaking' }"
          class="text-lg font-bold text-gray-900"
        >
          Mini IELTS
        </RouterLink>

        <div class="flex items-center gap-4">
          <span
            v-if="authStore.user"
            class="text-sm text-gray-600"
          >
            {{ authStore.user.name }}
          </span>

          <button
            type="button"
            class="text-sm font-medium text-gray-600 hover:text-gray-900"
            :disabled="authStore.loading"
            @click="handleLogout"
          >
            {{ authStore.loading ? 'Logging out...' : 'Logout' }}
          </button>
        </div>
      </div>
    </header>

    <main class="mx-auto max-w-6xl px-6 py-8">
      <RouterView />
    </main>
  </div>
</template>