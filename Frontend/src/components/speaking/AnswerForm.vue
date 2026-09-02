<script setup lang="ts">
import { computed, ref } from "vue";

import { submitSpeaking } from "@/api/speaking";
import type { SpeakingAttempt, SpeakingResult } from "@/api/types";

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

const maxLength = 1000;

const characterCount = computed(() => answer.value.length);

const canSubmit = computed(() => {
  return answer.value.trim().length > 0 && !loading.value;
});

const handleSubmit = async () => {
  if (!canSubmit.value) {
    return;
  }

  loading.value = true;
  errorMessage.value = "";

  try {
    const response = await submitSpeaking({
      question_id: props.questionId,
      answer: answer.value.trim(),
    });

    emit("submitted", response.data.data);
  } catch (error: any) {
    console.error("Failed to submit speaking answer:", error);

    if (error.response?.status === 422) {
      errorMessage.value =
        error.response.data.message ??
        "Please check your answer and try again.";
    } else {
      errorMessage.value = "Failed to submit your answer. Please try again.";
    }
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <form @submit.prevent="handleSubmit">
    <div class="flex items-center justify-between">
      <label for="speaking-answer" class="text-sm font-semibold text-gray-900">
        Your Answer
      </label>

      <span
        class="text-xs"
        :class="characterCount > maxLength ? 'text-red-500' : 'text-gray-400'"
      >
        {{ characterCount }} / {{ maxLength }}
      </span>
    </div>

    <div class="mt-3">
      <textarea
        id="speaking-answer"
        v-model="answer"
        :maxlength="maxLength"
        rows="7"
        placeholder="Type your answer here..."
        class="w-full resize-y rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm leading-6 text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10"
        :disabled="loading"
      />
    </div>

    <p class="mt-2 text-xs leading-5 text-gray-400">
      Try to give a complete answer with relevant details or examples.
    </p>

    <!-- Error -->
    <div
      v-if="errorMessage"
      class="mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3"
    >
      <p class="text-sm text-red-700">
        {{ errorMessage }}
      </p>
    </div>

    <!-- Submit -->
    <div class="mt-5 flex justify-end">
      <button
        type="submit"
        :disabled="!canSubmit"
        class="inline-flex min-w-32 items-center justify-center rounded-lg px-5 py-2.5 text-sm font-medium transition"
        :class="
          canSubmit
            ? 'bg-gray-900 text-white hover:bg-gray-800'
            : 'cursor-not-allowed bg-gray-100 text-gray-400'
        "
      >
        <span v-if="loading"> Evaluating... </span>

        <span v-else> Submit Answer </span>
      </button>
    </div>
  </form>
</template>
