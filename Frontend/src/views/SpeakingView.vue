<script setup lang="ts">
import { onMounted } from "vue";
import { useRouter } from "vue-router";

import { useSpeakingStore } from "@/stores/speaking";
import type { SpeakingAttempt, SpeakingResult } from "@/api/types";

import QuestionCard from "@/components/speaking/QuestionCard.vue";

const router = useRouter();
const speakingStore = useSpeakingStore();

type SubmittedData = {
  attempt: SpeakingAttempt;
  result: SpeakingResult;
};

const handleSubmitted = async (data: SubmittedData) => {
  await router.push({
    name: "result",
    params: {
      attemptId: data.attempt.id,
    },
  });
};

onMounted(() => {
  speakingStore.fetchQuestions();
});
</script>

<template>
  <section class="mx-auto max-w-4xl">
    <!-- Header -->
    <div class="mb-8">
      <div class="flex items-center gap-2">
        <span
          class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600"
        >
          IELTS Speaking
        </span>

        <span class="text-xs text-gray-400"> Practice Test </span>
      </div>

      <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900">
        Speaking Test
      </h1>

      <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
        Answer each question naturally and clearly. Your response will be
        evaluated using AI after submission.
      </p>
    </div>

    <!-- Instructions -->
    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
      <div class="flex gap-4">
        <div
          class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gray-100"
        >
          <span class="text-sm font-semibold text-gray-600"> i </span>
        </div>

        <div>
          <h2 class="text-sm font-semibold text-gray-900">Before you answer</h2>

          <p class="mt-1 text-sm leading-6 text-gray-500">
            Give a complete answer and try to support your ideas with relevant
            details or examples.
          </p>
        </div>
      </div>
    </div>

    <!-- Loading -->
    <div
      v-if="speakingStore.loading"
      class="rounded-xl border border-gray-200 bg-white p-12 text-center shadow-sm"
    >
      <p class="text-sm text-gray-500">Loading speaking questions...</p>
    </div>

    <!-- Error -->
    <div
      v-else-if="speakingStore.error"
      class="rounded-xl border border-red-200 bg-red-50 p-5"
    >
      <p class="text-sm font-medium text-red-700">
        {{ speakingStore.error }}
      </p>
    </div>

    <!-- Questions -->
    <div v-else-if="speakingStore.questions.length > 0" class="space-y-5">
      <div class="flex items-center justify-between">
        <p class="text-sm font-medium text-gray-700">Speaking Questions</p>

        <p class="text-xs text-gray-400">
          {{ speakingStore.questions.length }} questions
        </p>
      </div>

      <QuestionCard
        v-for="question in speakingStore.questions"
        :key="question.id"
        :question="question"
        @submitted="handleSubmitted"
      />
    </div>

    <!-- Empty -->
    <div
      v-else
      class="rounded-xl border border-gray-200 bg-white p-10 text-center shadow-sm"
    >
      <h2 class="text-lg font-semibold text-gray-900">
        No speaking questions available
      </h2>

      <p class="mt-2 text-sm text-gray-500">
        There are currently no questions available for the speaking test.
      </p>
    </div>
  </section>
</template>
