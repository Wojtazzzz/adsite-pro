import { useQuery } from '@tanstack/vue-query';
import { api } from '@/utils/functions';

export const useGetTasks = () => {
	const { isSuccess, isLoading, isError, data, error } = useQuery({
		queryKey: ['tasks'],
		queryFn: async () =>
			await api({
				url: '/api/tasks',
				method: 'GET',
			}),
	});

	return {
		isLoading,
		isSuccess,
		isError,
		data,
		error,
	};
};
