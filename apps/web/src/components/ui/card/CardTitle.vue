<script setup lang="ts">
import { CardTitle } from '@/components/ui-library/card';

defineProps<{
	tag: 'h1' | 'h2' | 'h3' | 'h4' | 'h5' | 'h6';
}>();
</script>

<template>
	<CardTitle :tag="tag">
		<slot />
	</CardTitle>
</template>
