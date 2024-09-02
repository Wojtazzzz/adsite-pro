import { api } from '@/utils/functions';
import { useQuery as useVueQuery } from '@tanstack/vue-query';
import { z } from 'zod';
import type { ComputedRef } from 'vue';
import { toValue } from 'vue';

type UseQueryOptions<T extends z.ZodTypeAny> = {
	url: ComputedRef<string> | string;
	cacheKey: ComputedRef<unknown[]> | unknown[];
	schema: T;
};

export const useQuery = <T extends z.ZodTypeAny>({ url, cacheKey, schema }: UseQueryOptions<T>) => {
	return useVueQuery({
		queryKey: toValue(cacheKey),
		queryFn: async (): Promise<z.infer<T>> => {
			const response = await api({
				url: toValue(url),
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
