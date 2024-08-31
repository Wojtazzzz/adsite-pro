import { useQuery } from '@tanstack/vue-query';
import { api } from '@/utils/functions';
import { computed, type ComputedRef } from 'vue';
import type { Team } from '@/modules/teams/useGetUserTeams';

export type User = {
	id: number;
	name: string;
};

export type GetTeamMembersResponse = {
	data: User[];
};

export const useGetTeamMembers = (team: ComputedRef<Team>) => {
	const { isSuccess, isLoading, isError, data, error } = useQuery({
		queryKey: ['team-members', team],
		queryFn: async () =>
			(await api({
				url: computed(() => `/api/teams/${team.value.id}/users`).value,
				method: 'GET',
			})) as Promise<GetTeamMembersResponse>,
	});

	return {
		isLoading,
		isSuccess,
		isError,
		users: data,
		error,
	};
};
