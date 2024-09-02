import { useQuery } from '@/composables/useQuery';
import { z } from 'zod';

const schema = z.object({
	data: z.array(
		z.object({
			id: z.number(),
			teamName: z.string(),
		}),
	),
});

export const useGetInvitations = () => {
	const { isSuccess, isLoading, isError, data, error } = useQuery({
		cacheKey: ['invitations'],
		url: '/api/invitations',
		schema,
	});

	return {
		isLoading,
		isSuccess,
		isError,
		invitations: data,
		error,
	};
};
