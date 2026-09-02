<script setup lang="ts">
import { onMounted, ref } from "vue";
import { getAttempts } from "@/api/speaking";
import type { SpeakingAttempt } from "@/api/types";

const attempts = ref<SpeakingAttempt[]>([]);
const loading = ref(true);
const errorMessage = ref("");

const fetchAttempts = async () => {
  loading.value = true;
  errorMessage.value = "";

  try {
    const response = await getAttempts();

    attempts.value = response.data.data;
  } catch (error) {
    console.error("Failed to fetch speaking attempts:", error);

    errorMessage.value = "Failed to load your speaking history.";
  } finally {
    loading.value = false;
  }
};

const formatDate = (date: string) => {
  return new Date(date).toLocaleString("en-US", {
    dateStyle: "medium",
    timeStyle: "short",
  });
};

onMounted(() => {
  fetchAttempts();
});
</script>

<template>
  <section class="mx-auto max-w-4xl">
    <!-- Header -->
    <div class="mb-8">
      <p class="text-sm font-medium text-gray-500">Progress</p>

      <h1 class="mt-1 text-3xl font-bold tracking-tight text-gray-900">
        Speaking History
      </h1>

      <p class="mt-2 text-sm text-gray-500">
        Review your previous speaking attempts and evaluations.
      </p>
    </div>

    <!-- Loading -->
    <div
      v-if="loading"
      class="rounded-xl border border-gray-200 bg-white p-10 text-center shadow-sm"
    >
      <p class="text-sm text-gray-500">Loading your history...</p>
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

    <!-- Empty -->
    <div
      v-else-if="attempts.length === 0"
      class="rounded-xl border border-gray-200 bg-white p-10 text-center shadow-sm"
    >
      <div
        class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100"
      >
        <span class="text-lg text-gray-500">?</span>
      </div>

      <h2 class="mt-4 text-lg font-semibold text-gray-900">No attempts yet</h2>

      <p class="mx-auto mt-2 max-w-md text-sm text-gray-500">
        Complete your first speaking test and your evaluation will appear here.
      </p>

      <RouterLink
        :to="{ name: 'speaking' }"
        class="mt-6 inline-flex rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-gray-800"
      >
        Start Speaking Test
      </RouterLink>
    </div>

    <!-- History List -->
    <div v-else class="space-y-4">
      <article
        v-for="attempt in attempts"
        :key="attempt.id"
        class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition hover:border-gray-300"
      >
        <!-- Card Header -->
        <div class="flex items-start justify-between gap-6 p-6">
          <div class="min-w-0">
            <div class="flex flex-wrap items-center gap-2">
              <span
                class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600"
              >
                {{ attempt.question.part }}
              </span>

              <span class="text-xs text-gray-400">
                {{ attempt.question.topic }}
              </span>
            </div>

            <h2 class="mt-3 text-base font-semibold leading-6 text-gray-900">
              {{ attempt.question.prompt }}
            </h2>
          </div>

          <!-- Band -->
          <div
            v-if="attempt.result"
            class="shrink-0 rounded-xl bg-gray-50 px-5 py-3 text-center"
          >
            <p class="text-xs font-medium text-gray-500">Band</p>

            <p class="mt-0.5 text-2xl font-bold text-gray-900">
              {{ attempt.result.estimated_band }}
            </p>
          </div>
        </div>

        <!-- Answer -->
        <div class="border-t border-gray-100 px-6 py-5">
          <p
            class="text-xs font-semibold uppercase tracking-wide text-gray-400"
          >
            Your Answer
          </p>

          <p class="mt-2 text-sm leading-6 text-gray-600">
            {{ attempt.answer }}
          </p>
        </div>

        <!-- Footer -->
        <div
          class="flex items-center justify-between border-t border-gray-100 bg-gray-50 px-6 py-4"
        >
          <p class="text-xs text-gray-500">
            {{ formatDate(attempt.submitted_at) }}
          </p>

          <RouterLink
            v-if="attempt.result"
            :to="{
              name: 'result',
              params: {
                attemptId: attempt.id,
              },
            }"
            class="text-sm font-semibold text-gray-900 hover:underline"
          >
            View Result →
          </RouterLink>

          <span v-else class="text-xs text-gray-400">
            Evaluation unavailable
          </span>
        </div>
      </article>
    </div>
  </section>
</template>
