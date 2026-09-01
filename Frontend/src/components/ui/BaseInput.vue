<script setup lang="ts">
withDefaults(
  defineProps<{
    modelValue: string
    type?: string
    placeholder?: string
    id: string
    label: string
    error?: string
  }>(),
  {
    type: 'text',
    placeholder: '',
    error: '',
  },
)

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
      :type="type"
      :value="modelValue"
      :placeholder="placeholder"
      :class="[
        'w-full rounded-lg border px-4 py-3 text-sm outline-none transition',
        error
          ? 'border-red-500 focus:border-red-500 focus:ring-2 focus:ring-red-500/10'
          : 'border-gray-300 focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10',
      ]"
      @input="
        emit(
          'update:modelValue',
          ($event.target as HTMLInputElement).value
        )
      "
    />

    <p
      v-if="error"
      class="text-sm text-red-600"
    >
      {{ error }}
    </p>
  </div>
</template>