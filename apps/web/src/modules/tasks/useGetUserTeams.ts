import { useQuery } from '@tanstack/vue-query';
import { api } from '@/utils/functions';

export type Team = {
	id: number;
	name: string;
	isOwner: boolean;
};

export type GetMemberTeamsResponse = {
	data: Team[];
};

export const useGetUserTeams = () => {
	const { isLoading, isError, data } = useQuery({
		queryKey: ['teams'],
		queryFn: async () =>
			(await api({
				url: '/api/teams',
				method: 'GET',
			})) as Promise<GetMemberTeamsResponse>,
	});

	return {
		isLoading,
		isError,
		teams: data,
	};
};
