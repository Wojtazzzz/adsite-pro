<script setup lang="ts">
import { Tabs } from '@/components/ui-library/tabs';

export type TabKey = string | number;

defineProps<{
	defaultTab: TabKey;
}>();
</script>

<template>
	<Tabs :default-value="defaultTab" class="w-full space-y-6">
		<slot />
	</Tabs>
</template>
