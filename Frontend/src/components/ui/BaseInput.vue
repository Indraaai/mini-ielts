<script setup lang="ts">
defineProps<{
  modelValue: string
  type?: string
  placeholder?: string
  id: string
  label: string
}>()

const emit = defineEmits<{
  'update:modelValue': [value: string]
}>()
</script>

<template>
  <div class="space-y-2">
    <label
      :for="id"
      class="block text-sm font-medium text-gray-700"
    >
      {{ label }}
    </label>

    <input
      :id="id"
      :type="type ?? 'text'"
      :value="modelValue"
      :placeholder="placeholder"
      class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10"
      @input="
        emit(
          'update:modelValue',
          ($event.target as HTMLInputElement).value
        )
      "
    />
  </div>
</template>