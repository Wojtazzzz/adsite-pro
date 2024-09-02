import { useQuery } from '@/composables/useQuery';
import { getUserTeamsResponseSchema } from '@/modules/teams/utils';

export const useGetUserTeams = () => {
	const { isLoading, isError, data } = useQuery({
		cacheKey: ['teams'],
		url: '/api/teams',
		schema: getUserTeamsResponseSchema,
	});

	return {
		isLoading,
		isError,
		teams: data,
	};
};
