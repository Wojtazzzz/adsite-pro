import { useQuery } from '@tanstack/vue-query';
import { api } from '@/utils/functions';
import { computed, type ComputedRef } from 'vue';

export type User = {
	id: number;
	name: string;
	tasks_count: number;
	idle_tasks_count: number;
	in_progress_tasks_count: number;
	completed_tasks_count: number;
	total_estimation: number;
};

export type GetTeamMembersDetailsResponse = {
	data: User[];
};

export const useGetTeamMembersDetails = (teamId: ComputedRef<number>) => {
	const { isSuccess, isLoading, isError, data, error } = useQuery({
		queryKey: ['team-members-details', teamId],
		queryFn: async () =>
			(await api({
				url: computed(() => `/api/teams/${teamId.value}/users/details`).value,
				method: 'GET',
			})) as Promise<GetTeamMembersDetailsResponse>,
	});

	return {
		isLoading,
		isSuccess,
		isError,
		users: data,
		error,
	};
};
