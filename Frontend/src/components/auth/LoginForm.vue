<script setup lang="ts">
import { ref } from "vue";
import { useRouter } from "vue-router";

import { useAuthStore } from "@/stores/auth";

import BaseButton from "@/components/ui/BaseButton.vue";
import BaseInput from "@/components/ui/BaseInput.vue";

const router = useRouter();
const authStore = useAuthStore();

const email = ref("");
const password = ref("");
const errorMessage = ref("");
const fieldErrors = ref<{ email?: string; password?: string }>({});

const handleSubmit = async () => {
  errorMessage.value = "";
  fieldErrors.value = {};

  try {
    await authStore.loginUser({
      email: email.value,
      password: password.value,
    });

    await router.push({
      name: "speaking",
    });
  } catch (error: any) {
    const response = error.response;

    if (response?.status === 422) {
      const errors = response.data.errors;

      const hasCredentialError =
        response.data.message === "These credentials do not match our records.";

      if (hasCredentialError) {
        errorMessage.value = "Email atau password salah.";
        return;
      }

      if (errors?.email || errors?.password) {
        fieldErrors.value = {
          email: errors.email?.[0],
          password: errors.password?.[0],
        };

        return;
      }

      errorMessage.value = "Data yang dimasukkan tidak valid.";
      return;
    }

    errorMessage.value = "Terjadi kesalahan. Silakan coba lagi.";
  }
};
</script>

<template>
  <form class="space-y-5" @submit.prevent="handleSubmit">
    <BaseInput
      id="email"
      v-model="email"
      type="email"
      label="Email"
      placeholder="you@example.com"
      :error="fieldErrors.email"
    />

    <BaseInput
      id="password"
      v-model="password"
      type="password"
      label="Password"
      placeholder="••••••••"
      :error="fieldErrors.password"
    />

    <p
      v-if="errorMessage"
      class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-600"
    >
      {{ errorMessage }}
    </p>

    <BaseButton type="submit" :disabled="authStore.loading">
      {{ authStore.loading ? "Signing in..." : "Sign In" }}
    </BaseButton>
  </form>
</template>
