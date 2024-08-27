<script setup lang="ts">
import { TabsList } from '@/components/ui-library/tabs';
</script>

<template>
	<TabsList class="space-x-4 bg-transparent">
		<slot />
	</TabsList>
</template>
