<script setup lang="ts">
import { DropdownMenuTrigger } from '@/components/ui-library/dropdown-menu';
</script>

<template>
	<DropdownMenuTrigger as-child>
		<slot />
	</DropdownMenuTrigger>
</template>
