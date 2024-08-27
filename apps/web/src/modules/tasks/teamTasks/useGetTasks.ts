import { useQuery } from '@tanstack/vue-query';
import { api } from '@/utils/functions';
import { computed, type ComputedRef, watch } from 'vue';

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

export const useGetTasks = (teamId: ComputedRef<number>) => {
	watch(teamId, () => {
		console.log('ddd', teamId);
	});

	const { isSuccess, isLoading, isError, data, error } = useQuery({
		queryKey: ['team-tasks'],
		queryFn: async () =>
			(await api({
				url: computed(() => `/api/teams/${teamId.value}`).value,
				method: 'GET',
			})) as Promise<GetTasksResponse>,
	});

	return {
		isLoading,
		isSuccess,
		isError,
		data,
		error,
	};
};
