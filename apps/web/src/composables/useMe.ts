import { useQuery } from '@/composables/useQuery';
import { z } from 'zod';

const schema = z.object({
	id: z.number(),
	name: z.string(),
});

export const useMe = () => {
	const { isSuccess, data } = useQuery({
		cacheKey: ['me'],
		url: '/api/me',
		schema,
	});

	return {
		isUserLogged: isSuccess,
		user: data,
	};
};
