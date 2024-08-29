<script setup lang="ts">
import { DialogContent } from '@/components/ui-library/dialog';

type DialogContentVerticalPosition = 'top' | 'center';

withDefaults(
	defineProps<{
		verticalPosition: DialogContentVerticalPosition;
	}>(),
	{
		verticalPosition: 'center',
	},
);
</script>

<template>
	<DialogContent
		:class="{
			'top-40': verticalPosition === 'top',
		}"
	>
		<slot />
	</DialogContent>
</template>
