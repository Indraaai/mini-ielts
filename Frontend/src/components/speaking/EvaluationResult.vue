<script setup lang="ts">
import type { SpeakingResult } from "@/api/types";

defineProps<{
  result: SpeakingResult;
}>();
</script>

<template>
  <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
    <!-- Header -->
    <div class="border-b border-gray-200 pb-6">
      <p class="text-sm font-medium text-gray-500">Speaking Evaluation</p>

      <h2 class="mt-1 text-2xl font-bold text-gray-900">Your Result</h2>
    </div>

    <!-- Estimated Band -->
    <div class="mt-6 rounded-xl bg-gray-50 p-6 text-center">
      <p class="text-sm font-medium text-gray-500">Estimated Band</p>

      <p class="mt-2 text-5xl font-bold text-gray-900">
        {{ result.estimated_band }}
      </p>
    </div>

    <!-- Strengths -->
    <div class="mt-8">
      <h3 class="text-lg font-semibold text-gray-900">Strengths</h3>

      <ul class="mt-3 space-y-3">
        <li
          v-for="strength in result.strengths"
          :key="strength"
          class="flex gap-3 text-sm leading-relaxed text-gray-600"
        >
          <span class="mt-1 shrink-0"> ✓ </span>

          <span>
            {{ strength }}
          </span>
        </li>
      </ul>
    </div>

    <!-- Areas to Improve -->
    <div class="mt-8">
      <h3 class="text-lg font-semibold text-gray-900">Areas to Improve</h3>

      <ul class="mt-3 space-y-3">
        <li
          v-for="area in result.areas_to_improve"
          :key="area"
          class="flex gap-3 text-sm leading-relaxed text-gray-600"
        >
          <span class="mt-1 shrink-0"> → </span>

          <span>
            {{ area }}
          </span>
        </li>
      </ul>
    </div>

    <!-- Feedback -->
    <div class="mt-8">
      <h3 class="text-lg font-semibold text-gray-900">Feedback</h3>

      <p class="mt-3 text-sm leading-relaxed text-gray-600">
        {{ result.feedback }}
      </p>
    </div>
  </div>
</template>
