<script setup lang="ts">
import { Alert, AlertDescription, AlertTitle } from '@/components/ui-library/alert'
import { ExclamationTriangleIcon } from '@radix-icons/vue'

defineProps<{
  content?: string | undefined
}>()
</script>

<template>
  <Alert variant="destructive">
    <ExclamationTriangleIcon class="w-4 h-4" />
    <AlertTitle>Error</AlertTitle>
    <AlertDescription>
      {{ content ?? '' }}
    </AlertDescription>
  </Alert>
</template>
