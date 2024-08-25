<script setup lang="ts">
import Header from '@/components/header/Header.vue';
</script>

<template>
	<main>
		<Header />

		<div class="min-w-screen min-h-screen flex justify-center items-center">
			<section class="max-w-xl w-full rounded-xl border p-7">
				<RouterView />
			</section>
		</div>
	</main>
</template>
