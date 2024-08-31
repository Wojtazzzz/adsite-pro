import { useQuery } from '@tanstack/vue-query';
import { api } from '@/utils/functions';
import { computed, type ComputedRef } from 'vue';
import type { Team } from '@/modules/teams/useGetUserTeams';

export type Category = {
	id: number;
	name: string;
	team_id: number;
	tasks: Task[];
};

export type Task = {
	id: number;
	category_id: number;
	name: string;
	description: string;
	estimation: number;
	status: 'IDLE' | 'IN_PROGRESS' | 'COMPLETED';
	created_at: string;
};

export type GetTasksResponse = {
	data: {
		id: number;
		name: string;
		categories: Category[];
	};
};

export const useGetTeamTasks = (team: ComputedRef<Team>) => {
	const { isSuccess, isLoading, isError, data, error } = useQuery({
		queryKey: ['team-tasks', team],
		queryFn: async () =>
			(await api({
				url: computed(() => `/api/teams/${team.value.id}`).value,
				method: 'GET',
			})) as Promise<GetTasksResponse>,
	});

	return {
		isLoading,
		isSuccess,
		isError,
		tasks: data,
		error,
	};
};
