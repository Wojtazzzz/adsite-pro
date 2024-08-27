<script setup lang="ts">
import CardContent from '@/components/ui/card/CardContent.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import Card from '@/components/ui/card/Card.vue';

defineProps<{
	categoryName: string;
}>();
</script>

<template>
	<Card>
		<CardHeader>
			<CardTitle tag="h2">
				<span class="text-xl uppercase">{{ categoryName }}</span>
			</CardTitle>
		</CardHeader>

		<CardContent>
			<slot />
		</CardContent>
	</Card>
</template>
