import { useMutation, useQueryClient } from '@tanstack/vue-query';
import { useToast } from '@/composables/useToast';
import { api } from '@/utils/functions';
import { responseErrorSchema } from '@/utils/schemas';

type RenameTeamPayload = {
	teamId: number;
	newName: string;
};

export const useRenameTeam = () => {
	const { callToast } = useToast();
	const queryClient = useQueryClient();

	const { mutate } = useMutation({
		mutationFn: async (payload: RenameTeamPayload) => {
			return await api({
				method: 'PATCH',
				url: `/api/teams/${payload.teamId}/rename`,
				payload: {
					name: payload.newName,
				},
			});
		},
		async onSuccess() {
			await queryClient.invalidateQueries({
				queryKey: ['teams'],
			});

			callToast({
				title: 'Success!',
				description: 'Your team has been renamed successfully!',
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

	const renameTeam = (payload: RenameTeamPayload, onSuccess: () => void) => {
		mutate(payload, {
			onSuccess,
		});
	};

	return {
		renameTeam,
	};
};
