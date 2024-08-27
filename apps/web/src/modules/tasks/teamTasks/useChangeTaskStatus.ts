import { useMutation } from '@tanstack/vue-query';
import { api } from '@/utils/functions';

type ChangeTaskStatusPayload = {
	id: number;
	newStatus: 'IDLE' | 'IN_PROGRESS' | 'COMPLETED';
};

export const useChangeTaskStatus = () => {
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
	});

	function changeStatus(payload: ChangeTaskStatusPayload) {
		mutate(payload);
	}

	return {
		changeStatus,
	};
};
