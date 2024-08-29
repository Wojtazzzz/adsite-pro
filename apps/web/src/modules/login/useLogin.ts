import { useToast } from '@/composables/useToast';
import { api } from '@/utils/functions';
import { useRouter } from 'vue-router';
import { useMutate } from '@/composables/useMutate';

type LoginPayload = {
	email: string;
	password: string;
};

export const useLogin = () => {
	const { callToast } = useToast();
	const router = useRouter();

	const { isError, error, mutate } = useMutate({
		apiCall: async (payload: LoginPayload) => {
			return await api({
				method: 'POST',
				url: '/api/login',
				payload,
			});
		},
		onSuccess: async () => {
			await router.push({
				name: 'home',
			});

			callToast({
				title: 'Welcome back!',
			});
		},
		toastErrors: false,
	});

	return {
		isError,
		error,
		login: mutate,
	};
};
