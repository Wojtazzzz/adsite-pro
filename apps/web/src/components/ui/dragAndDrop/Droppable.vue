<script setup lang="ts">
defineProps<{
	as: 'ul';
}>();
</script>

<template>
	<component :is="as" class="min-w-64 min-h-64 space-y-4">
		<slot />
	</component>
</template>
