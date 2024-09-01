import { useQueryClient } from '@tanstack/vue-query';
import { useToast } from '@/composables/useToast';
import { api } from '@/utils/functions';
import { useMutate } from '@/composables/useMutate';

type DeleteTeamMemberPayload = {
	teamId: number;
	userId: number;
};

export const useDeleteTeamMember = () => {
	const { callToast } = useToast();
	const queryClient = useQueryClient();

	const { mutate } = useMutate({
		apiCall: async (payload: DeleteTeamMemberPayload) => {
			return await api({
				method: 'DELETE',
				url: `/api/teams/${payload.teamId}/users/${payload.userId}`,
			});
		},
		onSuccess: async () => {
			await queryClient.invalidateQueries({
				queryKey: ['team-members-details'],
			});

			callToast({
				title: 'Success!',
				description: 'Team member has been deleted successfully!',
			});
		},
		toastErrors: true,
	});

	return {
		deleteTeamMember: mutate,
	};
};
