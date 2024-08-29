import { useToast } from '@/composables/useToast';
import { useQueryClient } from '@tanstack/vue-query';
import { api } from '@/utils/functions';
import { useMutate } from '@/composables/useMutate';

type CreateTeamPayload = {
	name: string;
};

export const useCreateTeam = () => {
	const { callToast } = useToast();
	const queryClient = useQueryClient();

	const { mutate } = useMutate({
		apiCall: async (payload: CreateTeamPayload) => {
			return await api({
				method: 'POST',
				url: '/api/teams',
				payload,
			});
		},
		onSuccess: async () => {
			callToast({
				title: 'Team successfully created',
			});

			await queryClient.invalidateQueries({
				queryKey: ['teams'],
			});
		},
		toastErrors: true,
	});

	return {
		createTeam: mutate,
	};
};
