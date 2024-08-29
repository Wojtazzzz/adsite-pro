<script setup lang="ts">
import { CommandEmpty, CommandList } from '@/components/ui-library/command';

defineProps<{
	emptyMessage: string;
}>();
</script>

<template>
	<CommandList>
		<CommandEmpty>{{ emptyMessage }}</CommandEmpty>

		<slot />
	</CommandList>
</template>
