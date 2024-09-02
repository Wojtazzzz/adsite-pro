<script setup lang="ts">
import { Textarea } from '@/components/ui-library/textarea';
import {
	FormItem,
	FormLabel,
	FormField,
	FormControl,
	FormMessage,
} from '@/components/ui-library/form';

defineProps<{
	name: string;
	label: string;
	placeholder?: string;
}>();
</script>

<template>
	<FormField v-slot="{ componentField }" :name="name">
		<FormItem>
			<FormLabel>
				<span class="cursor-pointer font-semibold">
					{{ label }}
				</span>
			</FormLabel>
			<FormControl>
				<Textarea :placeholder="placeholder" class="resize-none" v-bind="componentField" />
			</FormControl>
			<FormMessage />
		</FormItem>
	</FormField>
</template>
