import { useQueryClient } from '@tanstack/vue-query';
import { useToast } from '@/composables/useToast';
import { api } from '@/utils/functions';
import { useMutate } from '@/composables/useMutate';

type DeleteTeamPayload = {
	teamId: number;
};

export const useDeleteTeam = () => {
	const { callToast } = useToast();
	const queryClient = useQueryClient();

	const { mutate } = useMutate({
		apiCall: async (payload: DeleteTeamPayload) => {
			return await api({
				method: 'DELETE',
				url: `/api/teams/${payload.teamId}`,
			});
		},
		onSuccess: async () => {
			await queryClient.invalidateQueries({
				queryKey: ['teams'],
			});

			callToast({
				title: 'Success!',
				description: 'Your team has been deleted successfully!',
			});
		},
		toastErrors: true,
	});

	return {
		deleteTeam: mutate,
	};
};
