import { computed, type ComputedRef } from 'vue';
import { useQuery } from '@/composables/useQuery';
import { getTeamTasksResponseSchema } from '@/modules/teams/teamTasks/utils';
import type { Team } from '@/modules/teams/utils';

export const useGetTeamTasks = (team: ComputedRef<Team>) => {
	const { isSuccess, isLoading, isError, data, error } = useQuery({
		cacheKey: computed(() => ['team-tasks', team]),
		url: computed(() => `/api/teams/${team.value.id}`),
		schema: getTeamTasksResponseSchema,
	});

	return {
		isLoading,
		isSuccess,
		isError,
		tasks: data,
		error,
	};
};
