import { useQuery } from '@tanstack/vue-query';
import { api } from '@/utils/functions';

export type GetTasksResponse = {
	id: number;
	name: string;
	categories: {
		id: number;
		name: string;
		team_id: number;
		tasks: {
			id: number;
			category_id: number;
			name: string;
			description: string;
			estimation: number;
			status: string;
			created_at: string;
		}[];
	}[];
}[];

export const useGetTasks = () => {
	const { isSuccess, isLoading, isError, data, error } = useQuery({
		queryKey: ['tasks'],
		queryFn: async () =>
			(await api({
				url: '/api/tasks',
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
