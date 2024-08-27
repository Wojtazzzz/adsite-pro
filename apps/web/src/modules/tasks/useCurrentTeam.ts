import { ref } from 'vue';

export const useCurrentTeam = () => {
	const currentTeam = ref<number | null>(null);

	const updateTeam = (newTeamId: number) => {
		currentTeam.value = newTeamId;
	};

	return {
		currentTeam,
		updateTeam,
	};
};
