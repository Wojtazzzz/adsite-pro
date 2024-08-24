<script setup lang="ts" generic="Schema extends z.ZodTypeAny">
import { useForm } from 'vee-validate';
import * as z from 'zod';
import { toTypedSchema } from '@vee-validate/zod';

const props = defineProps<{
	schema: Schema;
	onSubmit: (values: z.infer<Schema>) => void;
}>();

const { handleSubmit } = useForm({
	validationSchema: toTypedSchema(props.schema),
});

const onSubmit = handleSubmit(props.onSubmit);
</script>

<template>
	<form @submit="onSubmit">
		<slot />
	</form>
</template>
