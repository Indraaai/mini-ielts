<script setup lang="ts">
import { onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";

import { getAttempt } from "@/api/speaking";
import type { SpeakingAttempt } from "@/api/types";

import EvaluationResult from "@/components/speaking/EvaluationResult.vue";

const route = useRoute();
const router = useRouter();

const attempt = ref<SpeakingAttempt | null>(null);
const loading = ref(true);
const errorMessage = ref("");

const fetchAttempt = async () => {
  loading.value = true;
  errorMessage.value = "";

  try {
    const attemptId = Number(route.params.attemptId);

    if (!attemptId) {
      errorMessage.value = "Invalid attempt ID.";
      return;
    }

    const response = await getAttempt(attemptId);

    attempt.value = response.data.data;
  } catch (error) {
    console.error("Failed to fetch speaking attempt:", error);

    errorMessage.value = "Failed to load the evaluation result.";
  } finally {
    loading.value = false;
  }
};

const goToSpeaking = () => {
  router.push({
    name: "speaking",
  });
};

onMounted(() => {
  fetchAttempt();
});
</script>

<template>
  <section>
    <!-- Header -->
    <div class="mb-8">
      <p class="text-sm font-medium text-gray-500">Speaking Evaluation</p>

      <h1 class="mt-1 text-2xl font-bold text-gray-900">Your Result</h1>
    </div>

    <!-- Loading -->
    <div v-if="loading" class="py-12 text-center text-sm text-gray-500">
      Loading result...
    </div>

    <!-- Error -->
    <div
      v-else-if="errorMessage"
      class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-600"
    >
      {{ errorMessage }}
    </div>

    <!-- Result -->
    <div v-else-if="attempt?.result">
      <EvaluationResult :result="attempt.result" />
      <button
        type="button"
        class="mt-6 rounded-lg bg-gray-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-gray-800"
        @click="goToSpeaking"
      >
        Back to Speaking Test
      </button>
    </div>

    <!-- No Result -->
    <div v-else class="rounded-lg bg-gray-50 px-4 py-3 text-sm text-gray-600">
      Evaluation result is not available.
    </div>
  </section>
</template>
