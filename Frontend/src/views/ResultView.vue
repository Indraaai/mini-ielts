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

const goToHistory = () => {
  router.push({
    name: "history",
  });
};

onMounted(() => {
  fetchAttempt();
});
</script>

<template>
  <section class="mx-auto max-w-4xl">
    <!-- Header -->
    <div class="mb-8">
      <p class="text-sm font-medium text-gray-500">Speaking Evaluation</p>

      <h1 class="mt-1 text-3xl font-bold tracking-tight text-gray-900">
        Your Result
      </h1>

      <p class="mt-2 text-sm text-gray-500">
        Review your speaking performance and AI-generated feedback.
      </p>
    </div>

    <!-- Loading -->
    <div
      v-if="loading"
      class="rounded-xl border border-gray-200 bg-white p-12 text-center shadow-sm"
    >
      <p class="text-sm text-gray-500">Loading your evaluation...</p>
    </div>

    <!-- Error -->
    <div
      v-else-if="errorMessage"
      class="rounded-xl border border-red-200 bg-red-50 p-5"
    >
      <p class="text-sm font-medium text-red-700">
        {{ errorMessage }}
      </p>
    </div>

    <!-- Result -->
    <div v-else-if="attempt?.result">
      <!-- Question -->
      <div
        class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm"
      >
        <div class="flex flex-wrap items-center gap-2">
          <span
            class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600"
          >
            {{ attempt.question.part }}
          </span>

          <span class="text-xs text-gray-400">
            {{ attempt.question.topic }}
          </span>
        </div>

        <h2 class="mt-4 text-lg font-semibold leading-7 text-gray-900">
          {{ attempt.question.prompt }}
        </h2>
      </div>

      <!-- Evaluation -->
      <EvaluationResult :result="attempt.result" />

      <!-- Answer -->
      <div
        class="mt-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm"
      >
        <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
          Your Answer
        </p>

        <p class="mt-3 text-sm leading-7 text-gray-600">
          {{ attempt.answer }}
        </p>
      </div>

      <!-- Actions -->
      <div class="mt-8 flex flex-col gap-3 sm:flex-row">
        <button
          type="button"
          class="rounded-lg bg-gray-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-gray-800"
          @click="goToSpeaking"
        >
          Try Another Question
        </button>

        <button
          type="button"
          class="rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
          @click="goToHistory"
        >
          View History
        </button>
      </div>
    </div>

    <!-- No result -->
    <div
      v-else
      class="rounded-xl border border-gray-200 bg-white p-10 text-center shadow-sm"
    >
      <h2 class="text-lg font-semibold text-gray-900">
        Evaluation result is not available
      </h2>

      <p class="mt-2 text-sm text-gray-500">
        This speaking attempt does not have an evaluation result yet.
      </p>

      <button
        type="button"
        class="mt-6 rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-800"
        @click="goToSpeaking"
      >
        Back to Speaking Test
      </button>
    </div>
  </section>
</template>
