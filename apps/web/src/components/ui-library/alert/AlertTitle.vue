<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/utils/functions';

const props = defineProps<{
	class?: HTMLAttributes['class'];
}>();
</script>

<template>
	<p :class="cn('mb-1 font-medium leading-none tracking-tight', props.class)">
		<slot />
	</p>
</template>
