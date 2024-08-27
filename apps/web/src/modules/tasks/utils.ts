import type { Ref } from 'vue';
import type { GetMemberTeamsResponse } from '@/modules/tasks/selectTeam/useGetMemberTeams';

export const mapTeamsToComboboxOptions = (data: Ref<GetMemberTeamsResponse | undefined>) => {
	if (!data.value) {
		return [];
	}

	return data.value.data.map((team) => ({
		value: team.id,
		label: team.name,
	}));
};
