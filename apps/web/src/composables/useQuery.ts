import { api } from '@/utils/functions';
import { useQuery as useVueQuery } from '@tanstack/vue-query';
import { z } from 'zod';

type UseQueryOptions<T extends z.ZodTypeAny> = {
	url: string;
	cacheKey: string[];
	schema: T;
};

export const useQuery = <T extends z.ZodTypeAny>({ url, cacheKey, schema }: UseQueryOptions<T>) => {
	return useVueQuery({
		queryKey: cacheKey,
		queryFn: async (): Promise<z.infer<T>> => {
			const response = await api({
				url,
				method: 'GET',
			});

			const result = await schema.safeParseAsync(response);

			if (result.success) {
				return result.data;
			}

			throw new Error('Server error.');
		},
	});
};
