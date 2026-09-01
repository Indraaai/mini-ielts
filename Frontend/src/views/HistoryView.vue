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
  <section>
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-2xl font-bold text-gray-900">Speaking History</h1>

      <p class="mt-2 text-sm text-gray-500">
        Review your previous speaking attempts and evaluations.
      </p>
    </div>

    <!-- Loading -->
    <div v-if="loading" class="py-12 text-center text-sm text-gray-500">
      Loading history...
    </div>

    <!-- Error -->
    <div
      v-else-if="errorMessage"
      class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-600"
    >
      {{ errorMessage }}
    </div>

    <!-- Empty -->
    <div
      v-else-if="attempts.length === 0"
      class="rounded-xl border border-gray-200 bg-white p-8 text-center shadow-sm"
    >
      <h2 class="font-semibold text-gray-900">No speaking attempts yet</h2>

      <p class="mt-2 text-sm text-gray-500">
        Complete a speaking test to see your history here.
      </p>
    </div>

    <!-- History -->
    <div v-else class="space-y-4">
      <article
        v-for="attempt in attempts"
        :key="attempt.id"
        class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm"
      >
        <!-- Attempt Header -->
        <div class="flex items-start justify-between gap-4">
          <div>
            <p class="text-xs font-medium text-gray-500">
              {{ attempt.question.part }}
            </p>

            <h2 class="mt-1 font-semibold text-gray-900">
              {{ attempt.question.prompt }}
            </h2>

            <p class="mt-1 text-xs text-gray-400">
              {{ formatDate(attempt.submitted_at) }}
            </p>
          </div>

          <!-- Band -->
          <div v-if="attempt.result" class="shrink-0 text-center">
            <p class="text-xs text-gray-500">Band</p>

            <p class="text-2xl font-bold text-gray-900">
              {{ attempt.result.estimated_band }}
            </p>
          </div>
        </div>

        <!-- Answer -->
        <div class="mt-5 border-t border-gray-100 pt-5">
          <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
            Your Answer
          </p>

          <p class="mt-2 text-sm leading-relaxed text-gray-600">
            {{ attempt.answer }}
          </p>
        </div>

        <!-- View Result -->
        <div v-if="attempt.result" class="mt-5">
          <RouterLink
            :to="{
              name: 'result',
              params: {
                attemptId: attempt.id,
              },
            }"
            class="text-sm font-medium text-gray-900 hover:underline"
          >
            View Evaluation →
          </RouterLink>
        </div>
      </article>
    </div>
  </section>
</template>
