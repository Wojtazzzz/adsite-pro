import { useToast } from '@/composables/useToast';
import { api } from '@/utils/functions';
import { useRouter } from 'vue-router';
import { useMutate } from '@/composables/useMutate';

type RegisterPayload = {
	name: string;
	email: string;
	password_confirmation: string;
	password: string;
};

export const useRegister = () => {
	const { callToast } = useToast();
	const router = useRouter();

	const { isError, error, mutate } = useMutate({
		apiCall: async (payload: RegisterPayload) => {
			return await api({
				method: 'POST',
				url: '/api/register',
				payload,
			});
		},
		onSuccess: async () => {
			await router.push({
				name: 'home',
			});

			callToast({
				title: 'Welcome!',
			});
		},
		toastErrors: false,
	});

	return {
		isError,
		error,
		register: mutate,
	};
};
