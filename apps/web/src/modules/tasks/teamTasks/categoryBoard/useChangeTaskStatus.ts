import { useQueryClient } from '@tanstack/vue-query';
import { api } from '@/utils/functions';
import { useMutate } from '@/composables/useMutate';

type ChangeTaskStatusPayload = {
	id: number;
	newStatus: 'IDLE' | 'IN_PROGRESS' | 'COMPLETED';
};

export const useChangeTaskStatus = () => {
	const queryClient = useQueryClient();

	const { mutate } = useMutate({
		apiCall: async (payload: ChangeTaskStatusPayload) => {
			return await api({
				method: 'PATCH',
				url: `/api/tasks/${payload.id}/status`,
				payload: {
					newStatus: payload.newStatus,
				},
			});
		},
		onSettled: async () => {
			await queryClient.invalidateQueries({
				queryKey: ['team-tasks'],
			});
		},
		toastErrors: true,
	});

	return {
		changeStatus: mutate,
	};
};
