import { ref } from 'vue';
import { type Team, useGetUserTeams } from '@/modules/tasks/useGetUserTeams';

export const useTeams = () => {
	const { teams, isError, isLoading } = useGetUserTeams();

	const currentTeam = ref<Team | null>(null);

	const updateTeam = (newTeamId: number) => {
		if (!teams.value) {
			return;
		}

		const selectedTeam = teams.value.data.find((team) => team.id === newTeamId);

		if (selectedTeam) {
			currentTeam.value = selectedTeam;
		}
	};

	return {
		teams,
		isError,
		isLoading,
		currentTeam,
		updateTeam,
	};
};
