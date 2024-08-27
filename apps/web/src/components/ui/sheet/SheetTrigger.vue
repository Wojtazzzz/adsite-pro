<script setup lang="ts">
import { SheetTrigger } from '@/components/ui-library/sheet';
</script>

<template>
	<SheetTrigger as-child>
		<slot />
	</SheetTrigger>
</template>
