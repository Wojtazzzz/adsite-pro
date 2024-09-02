<script setup lang="ts">
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
	placeholder?: string;
}>();
</script>

<template>
	<Select>
		<SelectTrigger>
			<SelectValue :placeholder="placeholder" />
		</SelectTrigger>
		<SelectContent>
			<template v-for="option in options" :key="option.value">
				<SelectItem :value="option.value">{{ option.label }}</SelectItem>
			</template>
		</SelectContent>
	</Select>
</template>
