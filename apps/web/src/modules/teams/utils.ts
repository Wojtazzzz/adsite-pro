import type { Ref } from 'vue';
import type { Team } from '@/modules/teams/useGetUserTeams';

export const mapTeamsToComboboxOptions = (teams: Ref<Team[] | undefined>) => {
	if (!teams.value) {
		return [];
	}

	return teams.value.map((team) => ({
		value: team.id,
		label: team.name,
	}));
};
