<script setup lang="ts">
import Button from '@/components/ui/Button.vue';
import Field from '@/components/ui/form/Field.vue';
import Form from '@/components/ui/form/Form.vue';
import Alert from '@/components/ui/Alert.vue';
import { useRegister } from '@/modules/register/useRegister';
import { type RegisterFormData, registerFormSchema } from '@/modules/register/utils';

const { isError, error, register } = useRegister();

const onSubmit = (values: RegisterFormData) => {
	register(values);
};
</script>

<template>
	<Form :schema="registerFormSchema" :on-submit="onSubmit">
		<div class="space-y-6">
			<Alert variant="destructive" v-show="isError">
				{{ error?.response.data.message }}
			</Alert>

			<Field type="text" name="name" label="Name" placeholder="John Smith" />
			<Field type="email" name="email" label="E-mail" placeholder="john.smith@gmail.com" />
			<Field type="password" name="password" label="Password" placeholder="********" />
			<Field
				type="password"
				name="password_confirmation"
				label="Repeat password"
				placeholder="********"
			/>

			<div class="flex justify-between gap-x-3">
				<span class="text-sm">
					Already have an account?
					<RouterLink class="underline" :to="{ name: 'login' }"> Login now! </RouterLink>
				</span>
				<Button type="submit">Register</Button>
			</div>
		</div>
	</Form>
</template>
