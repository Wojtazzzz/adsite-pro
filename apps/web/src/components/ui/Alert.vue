<script setup lang="ts">
import { Alert, AlertDescription, AlertTitle } from '@/components/ui-library/alert';
import { ExclamationTriangleIcon } from '@radix-icons/vue';

defineProps<{
	content: string;
	variant: 'default' | 'destructive';
}>();
</script>

<template>
	<Alert :variant="variant">
		<ExclamationTriangleIcon class="w-4 h-4" />
		<AlertTitle>
			<span class="font-semibold text-base">
				{{ variant === 'destructive' ? 'Error' : 'Warning' }}
			</span>
		</AlertTitle>
		<AlertDescription>
			{{ content }}
		</AlertDescription>
	</Alert>
</template>
