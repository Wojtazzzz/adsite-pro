<script setup lang="ts">
import { CommandInput } from '@/components/ui-library/command';

defineProps<{
	placeholder: string;
}>();
</script>

<template>
	<CommandInput :placeholder="placeholder" />
</template>
