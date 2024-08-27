<script setup lang="ts">
import Header from '@/components/header/Header.vue';
import Container from '@/components/ui/Container.vue';
</script>

<template>
	<main>
		<Header />

		<div class="min-w-screen min-h-screen flex justify-center items-center">
			<section class="max-w-xl w-full">
				<Container>
					<RouterView />
				</Container>
			</section>
		</div>
	</main>
</template>
