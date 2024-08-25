<script setup lang="ts">
import { NavigationMenu } from '@/components/ui-library/navigation-menu';

withDefaults(
	defineProps<{
		orientation?: 'vertical' | 'horizontal';
	}>(),
	{
		orientation: 'horizontal',
	},
);
</script>

<template>
	<NavigationMenu :orientation="orientation">
		<slot />
	</NavigationMenu>
</template>
