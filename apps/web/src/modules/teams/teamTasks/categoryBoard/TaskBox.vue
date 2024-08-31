<script setup lang="ts">
import CardTitle from '@/components/ui/card/CardTitle.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import Card from '@/components/ui/card/Card.vue';

defineProps<{
	taskName: string;
}>();
</script>

<template>
	<Card>
		<CardHeader class="p-4">
			<CardTitle tag="h3">
				{{ taskName }}
			</CardTitle>
		</CardHeader>
	</Card>
</template>
