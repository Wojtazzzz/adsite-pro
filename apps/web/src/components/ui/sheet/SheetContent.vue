<script setup lang="ts">
import {
	Sheet,
	SheetContent,
	SheetDescription,
	SheetHeader,
	SheetTitle,
	SheetTrigger,
} from '@/components/ui/sheet';
</script>

<template>
	<SheetContent>
		<slot />
	</SheetContent>
</template>
