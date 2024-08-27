<script setup lang="ts">
import LoginForm from '@/modules/login/LoginForm.vue';
import Card from '@/components/ui/card/Card.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
</script>

<template>
	<Card>
		<CardHeader>
			<CardTitle tag="h1">
				<span class="font-bold text-2xl">Login</span>
			</CardTitle>
		</CardHeader>
		<CardContent>
			<div class="space-y-4">
				<LoginForm />
			</div>
		</CardContent>
	</Card>
</template>
