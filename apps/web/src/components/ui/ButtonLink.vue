<script setup lang="ts">
import { Button } from '@/components/ui-library/button';
import { RouterLink } from 'vue-router';

type ButtonLinkVariant = 'default' | 'secondary' | 'outline';

withDefaults(
	defineProps<{
		variant?: ButtonLinkVariant;
		to: string;
	}>(),
	{
		variant: 'default',
	},
);
</script>

<template>
	<Button :variant="variant" :as="RouterLink" :to="to">
		<slot />
	</Button>
</template>
