import { useRoute } from 'vue-router';

export const useGetTeamId = () => {
	const route = useRoute();

	return isNaN(Number(route?.params?.teamId)) ? 0 : Number(route?.params?.teamId);
};
