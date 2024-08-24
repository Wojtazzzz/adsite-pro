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

	const { mutate, data, isPending, isError, error } = useMutation({
		mutationFn: async (payload: LoginPayload) => {
			return await api({
				method: 'POST',
				url: '/login',
				payload,
			});
		},
		async onSuccess(data, variables, context) {
			await router.push({
				name: 'home',
			});

			callToast({
				title: 'Witaj ponownie!',
			});
		},
	});

	const login = (credentials: LoginPayload) => {
		mutate(credentials);
	};

	return {
		isPending,
		data,
		isError,
		error,
		login,
	};
};
