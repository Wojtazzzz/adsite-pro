import { useToast } from '@/composables/useToast';
import { useMutation } from '@tanstack/vue-query';
import { api } from '@/utils/functions';
import { responseErrorSchema } from '@/utils/schemas';

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

	const createTeam = (credentials: CreateTeamPayload, onSuccess: () => void) => {
		mutate(credentials, {
			onSuccess,
		});
	};

	return {
		isError,
		error,
		createTeam,
	};
};
