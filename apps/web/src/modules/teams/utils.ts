import type { Ref } from 'vue';
import type { Team } from '@/modules/teams/useGetUserTeams';
import { z } from 'zod';

export const mapTeamsToComboboxOptions = (teams: Ref<Team[] | undefined>) => {
	if (!teams.value) {
		return [];
	}

	return teams.value.map((team) => ({
		value: team.id,
		label: team.name,
	}));
};

const teamSchema = z.object({
	id: z.number(),
	name: z.string(),
	isOwner: z.boolean(),
});

export const getUserTeamsResponseSchema = z.object({
	data: z.array(teamSchema),
});

export type Team = z.infer<typeof teamSchema>;
