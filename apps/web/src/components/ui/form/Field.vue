<script setup lang="ts">
import {
	FormControl,
	FormDescription,
	FormField,
	FormItem,
	FormLabel,
	FormMessage,
} from '@/components/ui-library/form';
import { Input } from '@/components/ui-library/input';
import { vAutoAnimate } from '@formkit/auto-animate/vue';

defineProps<{
	label: string;
	description?: string;
	name: string;
	placeholder: string;
	type: 'email' | 'password';
}>();
</script>

<template>
	<FormField v-slot="{ componentField }" :name="name" :validate-on-blur="false">
		<FormItem v-auto-animate>
			<FormLabel>
				<span class="cursor-pointer font-semibold">
					{{ label }}
				</span>
			</FormLabel>
			<FormControl>
				<Input :type="type" :placeholder="placeholder" v-bind="componentField" />
			</FormControl>
			<template v-if="description">
				<FormDescription>
					<span class="sr-only">
						{{ description }}
					</span>
				</FormDescription>
			</template>
			<FormMessage />
		</FormItem>
	</FormField>
</template>
