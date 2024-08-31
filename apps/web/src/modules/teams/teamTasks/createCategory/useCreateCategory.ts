import { useQueryClient } from '@tanstack/vue-query';
import { useToast } from '@/composables/useToast';
import { api } from '@/utils/functions';
import { useMutate } from '@/composables/useMutate';

type CreateCategoryPayload = {
	teamId: number;
	categoryName: string;
};

export const useCreateCategory = () => {
	const { callToast } = useToast();
	const queryClient = useQueryClient();

	const { mutate } = useMutate({
		apiCall: async (payload: CreateCategoryPayload) => {
			return await api({
				method: 'POST',
				url: `/api/teams/${payload.teamId}/categories`,
				payload: {
					name: payload.categoryName,
				},
			});
		},
		onSuccess: async () => {
			await queryClient.invalidateQueries({
				queryKey: ['team-tasks'],
			});

			callToast({
				title: 'Success!',
				description: 'Category has been created successfully!',
			});
		},
		toastErrors: true,
	});

	return {
		createCategory: mutate,
	};
};
