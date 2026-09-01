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
  <section>
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-2xl font-bold text-gray-900">Speaking Test</h1>

      <p class="mt-2 text-sm text-gray-500">
        Answer the following IELTS speaking questions.
      </p>
    </div>

    <!-- Loading -->
    <div
      v-if="speakingStore.loading"
      class="py-12 text-center text-sm text-gray-500"
    >
      Loading questions...
    </div>

    <!-- Error -->
    <div
      v-else-if="speakingStore.error"
      class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-600"
    >
      {{ speakingStore.error }}
    </div>

    <!-- Questions -->
    <div v-else-if="speakingStore.questions.length > 0" class="space-y-4">
      <QuestionCard
        v-for="question in speakingStore.questions"
        :key="question.id"
        :question="question"
        @submitted="handleSubmitted"
      />
    </div>

    <!-- Empty -->
    <div v-else class="py-12 text-center text-sm text-gray-500">
      No speaking questions available.
    </div>
  </section>
</template>
