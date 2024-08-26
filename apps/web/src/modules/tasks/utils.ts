import { type GetTasksResponse } from '@/modules/tasks/useGetTasks';
import type { Ref } from 'vue';

export const mapTeamsToComboboxOptions = (data: Ref<GetTasksResponse | undefined>) => {
	if (!data.value) {
		return [];
	}

	return data.value.data.map((team) => ({
		value: team.id,
		label: team.name,
	}));
};
