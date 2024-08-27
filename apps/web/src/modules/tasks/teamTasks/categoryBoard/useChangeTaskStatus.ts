import { useMutation, useQueryClient } from '@tanstack/vue-query';
import { api } from '@/utils/functions';

type ChangeTaskStatusPayload = {
	id: number;
	newStatus: 'IDLE' | 'IN_PROGRESS' | 'COMPLETED';
};

export const useChangeTaskStatus = () => {
	const queryClient = useQueryClient();

	const { mutate } = useMutation({
		mutationFn: async (payload: ChangeTaskStatusPayload) => {
			return await api({
				method: 'PATCH',
				url: `/api/tasks/${payload.id}/status`,
				payload: {
					newStatus: payload.newStatus,
				},
			});
		},
		async onSettled() {
			await queryClient.invalidateQueries({
				queryKey: ['team-tasks'],
			});
		},
	});

	function changeStatus(payload: ChangeTaskStatusPayload) {
		mutate(payload);
	}

	return {
		changeStatus,
	};
};
