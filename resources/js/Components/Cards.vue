<template>
  <div
    :class="`bg-${color}-100 text-${color}-800 p-2 rounded shadow text-center cursor-pointer`"
    style="min-width: 100px;"
    @mouseenter="hover = true"
    @mouseleave="hover = false"
    :style="hover ? 'box-shadow: 0 8px 16px rgba(0,0,0,0.2); transform: translateY(-2px); transition: all 0.3s ease;' : 'transition: all 0.3s ease;'"
  >
    <h4 class="text-xs font-medium mb-1">{{ title }}</h4>
    <p class="text-xl font-semibold">{{ value }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const hover = ref(false)

defineProps({
  title: String,
  value: [String, Number],
  color: {
    type: String,
    default: 'gray'
  }
})
</script>
