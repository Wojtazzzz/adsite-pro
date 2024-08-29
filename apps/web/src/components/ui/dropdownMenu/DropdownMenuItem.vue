<script setup lang="ts">
import { DropdownMenuItem } from '@/components/ui-library/dropdown-menu';
</script>

<template>
	<DropdownMenuItem as-child>
		<slot />
	</DropdownMenuItem>
</template>
