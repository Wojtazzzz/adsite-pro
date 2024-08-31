<script setup lang="ts">
import {
	FormControl,
	FormField,
	FormItem,
	FormLabel,
	FormMessage,
} from '@/components/ui-library/form';
import {
	NumberField,
	NumberFieldContent,
	NumberFieldDecrement,
	NumberFieldIncrement,
	NumberFieldInput,
} from '@/components/ui-library/number-field';

defineProps<{
	name: string;
	label: string;
	placeholder?: string;
}>();
</script>

<template>
	<FormField v-slot="{ value }" :name="name">
		<FormItem>
			<FormLabel>
				<span class="cursor-pointer font-semibold"> {{ label }} </span>
			</FormLabel>
			<NumberField class="gap-2" :min="15" :step="15" :model-value="value">
				<NumberFieldContent>
					<NumberFieldDecrement />
					<FormControl>
						<NumberFieldInput />
					</FormControl>
					<NumberFieldIncrement />
				</NumberFieldContent>
			</NumberField>
			<FormMessage />
		</FormItem>
	</FormField>
</template>
