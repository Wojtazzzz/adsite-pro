<script setup lang="ts">
import { DialogTrigger } from '@/components/ui-library/dialog';
</script>

<template>
	<DialogTrigger as-child>
		<slot />
	</DialogTrigger>
</template>
