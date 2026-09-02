<script setup lang="ts">
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";

const router = useRouter();
const authStore = useAuthStore();

const handleLogout = async () => {
  await authStore.logoutUser();

  await router.push({
    name: "login",
  });
};
</script>

<template>
  <div class="min-h-screen bg-gray-50">
    <header class="border-b border-gray-200 bg-white">
      <div
        class="mx-auto flex h-16 max-w-6xl items-center justify-between px-6"
      >
        <RouterLink
          :to="{ name: 'speaking' }"
          class="text-base font-bold tracking-tight text-gray-900"
        >
          Mini IELTS
        </RouterLink>

        <nav class="flex items-center gap-1 rounded-lg bg-gray-50 p-1">
          <RouterLink
            :to="{ name: 'speaking' }"
            class="rounded-md px-3 py-2 text-sm font-medium text-gray-500 transition hover:text-gray-900"
            active-class="bg-white text-gray-900 shadow-sm"
          >
            Speaking Test
          </RouterLink>

          <RouterLink
            :to="{ name: 'history' }"
            class="rounded-md px-3 py-2 text-sm font-medium text-gray-500 transition hover:text-gray-900"
            active-class="bg-white text-gray-900 shadow-sm"
          >
            History
          </RouterLink>
        </nav>

        <div class="flex items-center gap-4">
          <span
            v-if="authStore.user"
            class="hidden text-sm text-gray-500 sm:block"
          >
            {{ authStore.user.name }}
          </span>

          <button
            type="button"
            class="text-sm font-medium text-gray-500 transition hover:text-gray-900"
            :disabled="authStore.loading"
            @click="handleLogout"
          >
            {{ authStore.loading ? "Logging out..." : "Logout" }}
          </button>
        </div>
      </div>
    </header>

    <main class="mx-auto max-w-6xl px-6 py-10">
      <RouterView />
    </main>
  </div>
</template>
