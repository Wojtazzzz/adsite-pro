<script setup lang="ts">
import { AlertDialogTrigger } from '@/components/ui-library/alert-dialog';
</script>

<template>
	<AlertDialogTrigger as-child>
		<slot />
	</AlertDialogTrigger>
</template>
