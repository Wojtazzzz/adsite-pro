import { api } from '@/utils/functions';
import { useMutate } from '@/composables/useMutate';
import { useQueryClient } from '@tanstack/vue-query';

type ResponsePayload = {
	id: number;
	status: 'ACCEPTED' | 'REJECTED';
};

export const useRespondToInvitation = () => {
	const queryClient = useQueryClient();

	const { isError, error, mutate } = useMutate({
		apiCall: async (payload: ResponsePayload) => {
			return await api({
				method: 'PATCH',
				url: `/api/invitations/${payload.id}`,
				payload: {
					status: payload.status,
				},
			});
		},
		onSuccess: async () => {
			await queryClient.invalidateQueries({
				queryKey: ['invitations'],
			});
		},
		toastErrors: true,
	});

	const accept = (id: number) => {
		mutate({
			id,
			status: 'ACCEPTED',
		});
	};

	const reject = (id: number) => {
		mutate({
			id,
			status: 'REJECTED',
		});
	};

	return {
		isError,
		error,
		accept,
		reject,
	};
};
