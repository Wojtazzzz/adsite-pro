<script setup lang="ts">
import { CommandGroup } from '@/components/ui-library/command';

defineProps<{
	heading: string;
}>();
</script>

<template>
	<CommandGroup heading="Suggestions">
		<slot />
	</CommandGroup>
</template>
