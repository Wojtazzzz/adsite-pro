<script setup lang="ts">
import Button from '@/components/ui/Button.vue';
import Field from '@/components/ui/form/Field.vue';
import Form from '@/components/ui/form/Form.vue';
import Alert from '@/components/ui/Alert.vue';
import { useLogin } from '@/modules/login/useLogin';
import { type LoginFormData, loginFormSchema } from '@/modules/login/utils';

const { isError, error, login } = useLogin();

const onSubmit = (values: LoginFormData) => {
	login(values);
};
</script>

<template>
	<Form :schema="loginFormSchema" :on-submit="onSubmit">
		<div class="space-y-6">
			<Alert variant="destructive" v-show="isError">
				{{ error?.response.data.message }}
			</Alert>
			<Field type="email" name="email" label="E-mail" placeholder="john.smith@gmail.com" />
			<Field type="password" name="password" label="Password" placeholder="********" />

			<div class="flex justify-between gap-x-3">
				<span class="text-sm">
					Don't have an account?
					<RouterLink class="underline" :to="{ name: 'register' }">
						Register now!
					</RouterLink>
				</span>

				<Button type="submit">Login</Button>
			</div>
		</div>
	</Form>
</template>
