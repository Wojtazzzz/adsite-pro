import { computed } from 'vue';
import { useGetTeamId } from '@/modules/users/useGetTeamId';
import { useQuery } from '@/composables/useQuery';
import { getTeamMembersDetailsResponseSchema } from '@/modules/users/utils';

export const useGetTeamMembersDetails = () => {
	const teamId = useGetTeamId();

	const { isSuccess, isLoading, isError, data, error } = useQuery({
		cacheKey: ['team-members-details', teamId],
		url: computed(() => `/api/teams/${teamId}/users/details`),
		schema: getTeamMembersDetailsResponseSchema,
	});

	return {
		isLoading,
		isSuccess,
		isError,
		users: data,
		error,
	};
};
