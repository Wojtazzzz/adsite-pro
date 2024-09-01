<script setup lang="ts">
import { DialogContent } from '@/components/ui-library/dialog';

type DialogContentVerticalPosition = 'top' | 'center';

withDefaults(
	defineProps<{
		verticalPosition: DialogContentVerticalPosition;
		close?: boolean;
	}>(),
	{
		verticalPosition: 'center',
	},
);

defineEmits<{
	(e: 'closeClick'): void;
}>();
</script>

<template>
	<DialogContent
		@closeClick="$emit('closeClick')"
		:class="{
			'top-36': verticalPosition === 'top',
		}"
	>
		<slot />
	</DialogContent>
</template>
