<script setup lang="ts">
import type { NumberFieldDecrementProps } from 'radix-vue';
import { NumberFieldDecrement, useForwardProps } from 'radix-vue';
import { type HTMLAttributes, computed } from 'vue';
import { cn } from '@/utils/functions';

const props = defineProps<NumberFieldDecrementProps & { class?: HTMLAttributes['class'] }>();

const delegatedProps = computed(() => {
	const { class: _, ...delegated } = props;

	return delegated;
});

const forwarded = useForwardProps(delegatedProps);
</script>

<template>
	<NumberFieldDecrement
		data-slot="decrement"
		v-bind="forwarded"
		:class="
			cn(
				'absolute top-1/2 -translate-y-1/2 left-0 p-3 disabled:cursor-not-allowed disabled:opacity-20',
				props.class,
			)
		"
	>
		<slot>
			<svg
				width="15"
				height="15"
				viewBox="0 0 15 15"
				fill="none"
				xmlns="http://www.w3.org/2000/svg"
			>
				<path
					d="M2.25 7.5C2.25 7.22386 2.47386 7 2.75 7H12.25C12.5261 7 12.75 7.22386 12.75 7.5C12.75 7.77614 12.5261 8 12.25 8H2.75C2.47386 8 2.25 7.77614 2.25 7.5Z"
					fill="currentColor"
					fill-rule="evenodd"
					clip-rule="evenodd"
				></path>
			</svg>
		</slot>
	</NumberFieldDecrement>
</template>
