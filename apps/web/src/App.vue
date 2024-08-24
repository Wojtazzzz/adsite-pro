<script setup lang="ts">
import { RouterView } from 'vue-router'
import { Toaster } from '@/components/ui-library/toast'
</script>

<template>
  <div class="bg-slate-800">
    <RouterView />

    <Toaster />
  </div>
</template>
