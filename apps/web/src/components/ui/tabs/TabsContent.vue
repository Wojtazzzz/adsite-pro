<script setup lang="ts">
import { TabsContent } from '@/components/ui-library/tabs';
import type { TabKey } from '@/components/ui/tabs/Tabs.vue';

defineProps<{
	value: TabKey;
}>();
</script>

<template>
	<TabsContent :value="value">
		<slot />
	</TabsContent>
</template>
