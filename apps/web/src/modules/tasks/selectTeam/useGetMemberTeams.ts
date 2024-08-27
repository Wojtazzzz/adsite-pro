import { useQuery } from '@tanstack/vue-query';
import { api } from '@/utils/functions';

export type GetMemberTeamsResponse = {
	data: {
		id: number;
		name: string;
	}[];
};

export const useGetMemberTeams = () => {
	const { isSuccess, isLoading, isError, data, error } = useQuery({
		queryKey: ['teams'],
		queryFn: async () =>
			(await api({
				url: '/api/teams',
				method: 'GET',
			})) as Promise<GetMemberTeamsResponse>,
	});

	return {
		isLoading,
		isSuccess,
		isError,
		data,
		error,
	};
};
