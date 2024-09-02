import { computed, type ComputedRef } from 'vue';
import { useQuery } from '@/composables/useQuery';
import { getTeamMembersResponseSchema } from '@/modules/teams/teamTasks/categoryBoard/utils';
import type { Team } from '@/modules/teams/utils';

export const useGetTeamMembers = (team: ComputedRef<Team>) => {
	const { isSuccess, isLoading, isError, data, error } = useQuery({
		cacheKey: ['team-members', team],
		url: computed(() => `/api/teams/${team.value.id}/users`).value,
		schema: getTeamMembersResponseSchema,
	});

	return {
		isLoading,
		isSuccess,
		isError,
		users: data,
		error,
	};
};
