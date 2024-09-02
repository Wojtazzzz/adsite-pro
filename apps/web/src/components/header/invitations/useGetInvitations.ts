import { useQuery } from '@tanstack/vue-query';
import { api } from '@/utils/functions';

export type GetTasksResponse = {
	data: {
		id: number;
		team_name: string;
	}[];
};

export const useGetInvitations = () => {
	const { isSuccess, isLoading, isError, data, error } = useQuery({
		queryKey: ['invitations'],
		queryFn: async () =>
			(await api({
				url: '/api/invitations',
				method: 'GET',
			})) as Promise<GetTasksResponse>,
	});

	return {
		isLoading,
		isSuccess,
		isError,
		invitations: data,
		error,
	};
};
