<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/utils/functions';

const props = defineProps<{
	class?: HTMLAttributes['class'];
}>();
</script>

<template>
	<td
		:class="
			cn(
				'p-2 text-nowrap align-middle [&:has([role=checkbox])]:pr-0 [&>[role=checkbox]]:translate-y-0.5',
				props.class,
			)
		"
	>
		<slot />
	</td>
</template>
