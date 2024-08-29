<script setup lang="ts">
import { CommandItem } from '@/components/ui-library/command';

defineProps<{
	value: string;
}>();
</script>

<template>
	<CommandItem :value="value">
		<slot />
	</CommandItem>
</template>
