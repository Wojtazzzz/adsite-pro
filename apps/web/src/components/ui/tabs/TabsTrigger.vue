<script setup lang="ts">
import { TabsTrigger } from '@/components/ui-library/tabs';
import type { TabKey } from '@/components/ui/tabs/Tabs.vue';

defineProps<{
	value: TabKey;
}>();
</script>

<template>
	<TabsTrigger as-child :value="value">
		<slot />
	</TabsTrigger>
</template>
