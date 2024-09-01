import { useToast } from '@/composables/useToast';
import { api } from '@/utils/functions';
import { useMutate } from '@/composables/useMutate';
import { useGetTeamId } from '@/modules/users/useGetTeamId';
import { computed } from 'vue';

type InviteUserPayload = {
	email: string;
};

export const useInviteUser = () => {
	const teamId = useGetTeamId();
	const { callToast } = useToast();

	const { mutate } = useMutate({
		apiCall: async (payload: InviteUserPayload) => {
			return await api({
				method: 'POST',
				url: computed(() => `/api/teams/${teamId}/invitations`).value,
				payload: {
					email: payload.email,
				},
			});
		},
		onSuccess: async () => {
			callToast({
				title: 'Invitation successfully sent!',
			});
		},
		toastErrors: true,
	});

	return {
		invite: mutate,
	};
};
