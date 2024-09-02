<script setup lang="ts">
import {
	FormControl,
	FormField,
	FormItem,
	FormLabel,
	FormMessage,
} from '@/components/ui-library/form';
import {
	Select,
	SelectContent,
	SelectItem,
	SelectTrigger,
	SelectValue,
} from '@/components/ui-library/select';

export type SelectOption<Value extends string> = {
	value: Value;
	label: string;
};

defineProps<{
	options: SelectOption<string>[];
	label: string;
	placeholder?: string;
}>();
</script>

<template>
	<FormField v-slot="{ componentField }" name="email">
		<FormItem>
			<FormLabel>
				<span class="cursor-pointer font-semibold">
					{{ label }}
				</span>
			</FormLabel>

			<Select v-bind="componentField">
				<FormControl>
					<SelectTrigger>
						<SelectValue :placeholder="placeholder" />
					</SelectTrigger>
				</FormControl>
				<SelectContent>
					<template v-for="option in options" :key="option.value">
						<SelectItem :value="option.value">{{ option.label }}</SelectItem>
					</template>
				</SelectContent>
			</Select>
			<FormMessage />
		</FormItem>
	</FormField>
</template>
