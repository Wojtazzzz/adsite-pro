<script setup lang="ts">
defineProps<{
	as: 'li';
}>();
</script>

<template>
	<component :is="as" draggable="true">
		<slot />
	</component>
</template>
