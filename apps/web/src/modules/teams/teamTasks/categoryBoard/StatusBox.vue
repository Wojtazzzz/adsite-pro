<script setup lang="ts">
import CardContent from '@/components/ui/card/CardContent.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import Card from '@/components/ui/card/Card.vue';

defineProps<{
	statusName: string;
}>();
</script>

<template>
	<Card>
		<CardHeader>
			<div class="flex justify-between">
				<CardTitle tag="h2">
					<span class="text-xl uppercase">{{ statusName }}</span>
				</CardTitle>

				<slot name="options" />
			</div>
		</CardHeader>

		<CardContent>
			<slot />
		</CardContent>
	</Card>
</template>
