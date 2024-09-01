import { useQueryClient } from '@tanstack/vue-query';
import { api } from '@/utils/functions';
import { useMutate } from '@/composables/useMutate';
import type { TaskStatus } from '@/utils/schemas';

type ChangeTaskStatusPayload = {
	id: number;
	teamId: number;
	categoryId: number;
	newStatus: TaskStatus;
};

export const useChangeTaskStatus = () => {
	const queryClient = useQueryClient();

	const { mutate } = useMutate({
		apiCall: async (payload: ChangeTaskStatusPayload) => {
			return await api({
				method: 'PATCH',
				url: `/api/teams/${payload.teamId}/categories/${payload.categoryId}/tasks/${payload.id}/status`,
				payload: {
					status: payload.newStatus,
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
