import { useQueryClient } from '@tanstack/vue-query';
import { useToast } from '@/composables/useToast';
import { api } from '@/utils/functions';
import { useMutate } from '@/composables/useMutate';

type CreateTaskPayload = {
	userId: number;
	teamId: number;
	categoryId: number;
	name: string;
	description: string;
	estimation: number;
	status: string;
};

export const useCreateTask = () => {
	const { callToast } = useToast();
	const queryClient = useQueryClient();

	const { mutate } = useMutate({
		apiCall: async (payload: CreateTaskPayload) => {
			return await api({
				method: 'POST',
				url: `/api/teams/${payload.teamId}/categories/${payload.categoryId}/tasks`,
				payload: {
					user_id: payload.userId,
					name: payload.name,
					description: payload.description,
					estimation: payload.estimation,
					status: payload.status,
				},
			});
		},
		onSuccess: async () => {
			await queryClient.invalidateQueries({
				queryKey: ['team-tasks'],
			});

			callToast({
				title: 'Success!',
				description: 'Your task has been created successfully!',
			});
		},
		toastErrors: true,
	});

	return {
		createTask: mutate,
	};
};
