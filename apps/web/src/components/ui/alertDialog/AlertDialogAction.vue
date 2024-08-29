<script setup lang="ts">
import { AlertDialogAction } from '@/components/ui-library/alert-dialog';
</script>

<template>
	<AlertDialogAction as-child>
		<slot />
	</AlertDialogAction>
</template>
