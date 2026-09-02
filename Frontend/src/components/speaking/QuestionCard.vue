<script setup lang="ts">
import type { SpeakingQuestion } from "@/api/types";

import AnswerForm from "./AnswerForm.vue";

defineProps<{
  question: SpeakingQuestion;
}>();

const emit = defineEmits<{
  submitted: [
    data: {
      attempt: any;
      result: any;
    },
  ];
}>();
</script>

<template>
  <article
    class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm"
  >
    <!-- Question Header -->
    <div class="border-b border-gray-100 px-6 py-5">
      <div class="flex flex-wrap items-center gap-2">
        <span
          class="rounded-full bg-gray-900 px-3 py-1 text-xs font-medium text-white"
        >
          {{ question.part }}
        </span>

        <span
          class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600"
        >
          {{ question.topic }}
        </span>
      </div>

      <div class="mt-5 flex gap-4">
        <div
          class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-gray-100"
        >
          <span class="text-sm font-semibold text-gray-500"> Q </span>
        </div>

        <div>
          <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
            Question
          </p>

          <h2 class="mt-1 text-lg font-semibold leading-7 text-gray-900">
            {{ question.prompt }}
          </h2>
        </div>
      </div>
    </div>

    <!-- Answer -->
    <div class="px-6 py-6">
      <AnswerForm
        :question-id="question.id"
        @submitted="emit('submitted', $event)"
      />
    </div>
  </article>
</template>
