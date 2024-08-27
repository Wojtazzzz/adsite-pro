<script setup lang="ts">
import CardContent from '@/components/ui/card/CardContent.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import Card from '@/components/ui/card/Card.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import RegisterForm from '@/modules/register/RegisterForm.vue';
</script>

<template>
	<Card>
		<CardHeader>
			<CardTitle tag="h1">
				<span class="font-bold text-2xl">Register</span>
			</CardTitle>
		</CardHeader>
		<CardContent>
			<div class="space-y-4">
				<RegisterForm />
			</div>
		</CardContent>
	</Card>
</template>
