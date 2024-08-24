<script setup lang="ts">
import { Button } from '@/components/ui-library/button';
defineProps<{
	type: 'button' | 'submit';
}>();
</script>

<template>
	<Button :type="type">
		<slot />
	</Button>
</template>
