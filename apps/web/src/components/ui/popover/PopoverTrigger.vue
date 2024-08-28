<script setup lang="ts">
import { PopoverTrigger } from '@/components/ui-library/popover';
</script>

<template>
	<PopoverTrigger as-child>
		<slot />
	</PopoverTrigger>
</template>
