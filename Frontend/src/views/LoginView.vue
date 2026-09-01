<script setup lang="ts">
import BaseCard from '@/components/ui/BaseCard.vue'
import LoginForm from '@/components/auth/LoginForm.vue'
</script>

<template>
  <main
    class="flex min-h-screen items-center justify-center bg-gray-50 px-4"
  >
    <div class="w-full max-w-md">
      <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-900">
          Mini IELTS
        </h1>

        <p class="mt-2 text-sm text-gray-500">
          Practice your IELTS speaking skills
        </p>
      </div>

      <BaseCard>
        <div class="mb-6">
          <h2 class="text-xl font-semibold text-gray-900">
            Welcome back
          </h2>

          <p class="mt-1 text-sm text-gray-500">
            Sign in to continue your practice.
          </p>
        </div>

        <LoginForm />
      </BaseCard>
    </div>
  </main>
</template>