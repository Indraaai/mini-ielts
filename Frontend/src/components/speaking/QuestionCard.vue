<script setup lang="ts">
import type {
  SpeakingAttempt,
  SpeakingQuestion,
  SpeakingResult,
} from "@/api/types";

import AnswerForm from "./AnswerForm.vue";

defineProps<{
  question: SpeakingQuestion;
}>();

const emit = defineEmits<{
  submitted: [
    data: {
      attempt: SpeakingAttempt;
      result: SpeakingResult;
    },
  ];
}>();
</script>

<template>
  <article class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
    <div class="mb-4 flex items-center justify-between">
      <span
        class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700"
      >
        {{ question.part }}
      </span>

      <span class="text-sm text-gray-500">
        {{ question.topic }}
      </span>
    </div>

    <h2 class="text-xl font-semibold leading-relaxed text-gray-900">
      {{ question.prompt }}
    </h2>

    <AnswerForm
      :question-id="question.id"
      @submitted="emit('submitted', $event)"
    />
  </article>
</template>
