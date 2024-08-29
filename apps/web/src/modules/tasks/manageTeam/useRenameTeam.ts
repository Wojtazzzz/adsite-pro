import { useQueryClient } from '@tanstack/vue-query';
import { useToast } from '@/composables/useToast';
import { api } from '@/utils/functions';
import { useMutate } from '@/composables/useMutate';

type RenameTeamPayload = {
	teamId: number;
	newName: string;
};

export const useRenameTeam = () => {
	const { callToast } = useToast();
	const queryClient = useQueryClient();

	const { mutate } = useMutate({
		apiCall: async (payload: RenameTeamPayload) => {
			return await api({
				method: 'PATCH',
				url: `/api/teams/${payload.teamId}/rename`,
				payload: {
					name: payload.newName,
				},
			});
		},
		onSuccess: async () => {
			await queryClient.invalidateQueries({
				queryKey: ['teams'],
			});

			callToast({
				title: 'Success!',
				description: 'Your team has been renamed successfully!',
			});
		},
		toastErrors: true,
	});

	return {
		renameTeam: mutate,
	};
};
