<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/utils/functions';

const props = defineProps<{
	tag: 'h1' | 'h2' | 'h3' | 'h4' | 'h5' | 'h6';
	class?: HTMLAttributes['class'];
}>();
</script>

<template>
	<component :is="tag" :class="cn('font-semibold leading-none tracking-tight', props.class)">
		<slot />
	</component>
</template>
