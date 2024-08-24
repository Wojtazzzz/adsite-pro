import { useMutation } from '@tanstack/vue-query';
import { useToast } from '@/composables/useToast';
import { api } from '@/utils/functions';
import { useRouter } from 'vue-router';

type RegisterPayload = {
	name: string;
	email: string;
	password_confirmation: string;
	password: string;
};

export const useRegister = () => {
	const { callToast } = useToast();
	const router = useRouter();

	const { mutate, isError, error } = useMutation({
		mutationFn: async (payload: RegisterPayload) => {
			return await api({
				method: 'POST',
				url: '/api/register',
				payload,
			});
		},
		async onSuccess() {
			await router.push({
				name: 'home',
			});

			callToast({
				title: 'Welcome!',
			});
		},
	});

	const register = (credentials: RegisterPayload) => {
		mutate(credentials);
	};

	return {
		isError,
		error,
		register,
	};
};
