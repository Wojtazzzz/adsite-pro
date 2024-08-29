<script setup lang="ts">
import { AlertDialogCancel } from '@/components/ui-library/alert-dialog';
</script>

<template>
	<AlertDialogCancel as-child>
		<slot />
	</AlertDialogCancel>
</template>
