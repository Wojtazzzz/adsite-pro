<script setup lang="ts">
import { Button } from '@/components/ui-library/button';

type ButtonVariant = 'default' | 'secondary' | 'outline' | 'destructive' | 'ghost';

withDefaults(
	defineProps<{
		type: 'button' | 'submit';
		variant?: ButtonVariant;
	}>(),
	{
		variant: 'default',
	},
);
</script>

<template>
	<Button :type="type" :variant="variant">
		<slot />
	</Button>
</template>
