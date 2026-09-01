<script setup lang="ts">
import { ref } from "vue";

import { submitSpeaking } from "@/api/speaking";
import type { SpeakingResult, SpeakingAttempt } from "@/api/types";

import BaseButton from "@/components/ui/BaseButton.vue";

const props = defineProps<{
  questionId: number;
}>();

const emit = defineEmits<{
  submitted: [
    data: {
      attempt: SpeakingAttempt;
      result: SpeakingResult;
    },
  ];
}>();

const answer = ref("");
const loading = ref(false);
const errorMessage = ref("");

const handleSubmit = async () => {
  errorMessage.value = "";

  if (!answer.value.trim()) {
    errorMessage.value = "Please provide an answer.";
    return;
  }

  loading.value = true;

  try {
    const response = await submitSpeaking({
      question_id: props.questionId,
      answer: answer.value.trim(),
    });

    emit("submitted", response.data.data);
  } catch {
    errorMessage.value = "Failed to submit your answer. Please try again.";
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <form class="mt-6 space-y-4" @submit.prevent="handleSubmit">
    <div>
      <label for="answer" class="mb-2 block text-sm font-medium text-gray-700">
        Your Answer
      </label>

      <textarea
        id="answer"
        v-model="answer"
        rows="6"
        placeholder="Write your answer here..."
        :disabled="loading"
        class="w-full resize-none rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 disabled:bg-gray-100"
      />
    </div>

    <p
      v-if="errorMessage"
      class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-600"
    >
      {{ errorMessage }}
    </p>

    <BaseButton type="submit" :disabled="loading">
      {{ loading ? "Evaluating..." : "Submit Answer" }}
    </BaseButton>
  </form>
</template>
