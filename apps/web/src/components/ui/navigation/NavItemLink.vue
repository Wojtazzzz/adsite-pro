<script setup lang="ts">
import {
	NavigationMenuLink,
	navigationMenuTriggerStyle,
} from '@/components/ui-library/navigation-menu';

defineProps<{
	to: string;
}>();
</script>

<template>
	<RouterLink :to="to">
		<NavigationMenuLink :class="navigationMenuTriggerStyle()">
			<slot />
		</NavigationMenuLink>
	</RouterLink>
</template>
