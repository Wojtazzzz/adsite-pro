<script setup lang="ts">
import { Tabs } from '@/components/ui-library/tabs';

export type TabKey = string | number;

defineProps<{
	defaultTab: TabKey;
}>();
</script>

<template>
	<Tabs :default-value="defaultTab">
		<slot />
	</Tabs>
</template>
