<script setup lang="ts">
import Combobox from '@/components/ui/Combobox.vue';
import { useGetMemberTeams } from '@/modules/tasks/selectTeam/useGetMemberTeams';
import { computed, watch } from 'vue';
import { mapTeamsToComboboxOptions } from '@/modules/tasks/utils';

const emit = defineEmits<{
	(e: 'update', id: number): void;
}>();

const currentTeam = defineModel<number | null>({
	default: null,
});

const { data } = useGetMemberTeams();

const teamsOptions = computed(() => mapTeamsToComboboxOptions(data));

watch(data, () => {
	if (currentTeam.value !== null) {
		return;
	}

	if (data.value && data.value.data.length > 0) {
		currentTeam.value = data.value.data[0].id;

		emit('update', data.value.data[0].id);
	}
});
</script>

<template>
	<Combobox
		:model-value="currentTeam"
		:options="teamsOptions"
		not-found-message="No team found"
		placeholder="Select team"
		@update:model-value="(value) => console.log('sss: ', value)"
	/>
</template>
