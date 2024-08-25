import { useQuery } from '@tanstack/vue-query';
import { api } from '@/utils/functions';

export const useMe = () => {
	const { isSuccess, data } = useQuery({
		queryKey: ['me'],
		queryFn: async () =>
			await api({
				url: '/api/me',
				method: 'GET',
			}),
	});

	return {
		isUserLogged: isSuccess,
		user: data,
	};
};
