import { useMutation, useQueryClient } from '@tanstack/vue-query';
import { useToast } from '@/composables/useToast';
import { api } from '@/utils/functions';
import { responseErrorSchema } from '@/utils/schemas';

type DeleteTeamPayload = {
	teamId: number;
};

export const useDeleteTeam = () => {
	const { callToast } = useToast();
	const queryClient = useQueryClient();

	const { mutate } = useMutation({
		mutationFn: async (payload: DeleteTeamPayload) => {
			return await api({
				method: 'DELETE',
				url: `/api/teams/${payload.teamId}`,
			});
		},
		async onSuccess() {
			await queryClient.invalidateQueries({
				queryKey: ['teams'],
			});

			callToast({
				title: 'Your team has been deleted successfully!',
			});
		},
		async onError(error) {
			const { success, data } = await responseErrorSchema.safeParseAsync(error);

			if (success) {
				return callToast({
					title: 'Error!',
					description: data.response.data.message,
				});
			}

			return callToast({
				title: 'Error!',
				description: 'Something went wrong',
			});
		},
	});

	const deleteTeam = (payload: DeleteTeamPayload) => {
		mutate(payload);
	};

	return {
		deleteTeam,
	};
};
