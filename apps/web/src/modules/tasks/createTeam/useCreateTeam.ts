import { useToast } from '@/composables/useToast';
import { useMutation } from '@tanstack/vue-query';
import { api } from '@/utils/functions';

type CreateTeamPayload = {
	name: string;
};

export const useCreateTeam = () => {
	const { callToast } = useToast();

	const { mutate, isError, error } = useMutation({
		mutationFn: async (payload: CreateTeamPayload) => {
			return await api({
				method: 'POST',
				url: '/api/teams',
				payload,
			});
		},
		async onSuccess() {
			callToast({
				title: 'Team successfully created',
			});
		},
	});

	const createTeam = (credentials: CreateTeamPayload) => {
		mutate(credentials);
	};

	return {
		isError,
		error,
		createTeam,
	};
};
