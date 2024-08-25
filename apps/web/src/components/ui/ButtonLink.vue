<script setup lang="ts">
import { Button } from '@/components/ui-library/button';
import { RouterLink } from 'vue-router';

defineProps<{
	to: string;
}>();
</script>

<template>
	<Button :as="RouterLink" :to="to">
		<slot />
	</Button>
</template>
