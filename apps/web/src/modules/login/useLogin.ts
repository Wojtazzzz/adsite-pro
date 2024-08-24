import { useMutation } from '@tanstack/vue-query';
import { useToast } from '@/composables/useToast';
import { api } from '@/utils/functions';
import { useRouter } from 'vue-router';

type LoginPayload = {
	email: string;
	password: string;
};

export const useLogin = () => {
	const { callToast } = useToast();
	const router = useRouter();

	const { mutate, isError, error } = useMutation({
		mutationFn: async (payload: LoginPayload) => {
			return await api({
				method: 'POST',
				url: '/login',
				payload,
			});
		},
		async onSuccess() {
			await router.push({
				name: 'home',
			});

			callToast({
				title: 'Welcome back!',
			});
		},
	});

	const login = (credentials: LoginPayload) => {
		mutate(credentials);
	};

	return {
		isError,
		error,
		login,
	};
};
