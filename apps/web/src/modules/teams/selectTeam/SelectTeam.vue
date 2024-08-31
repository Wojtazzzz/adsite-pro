<script setup lang="ts">
import Combobox from '@/components/ui/Combobox.vue';
import { type Team } from '@/modules/teams/useGetUserTeams';
import { computed, onMounted, toRef, watch } from 'vue';
import { mapTeamsToComboboxOptions } from '@/modules/teams/utils';

const props = defineProps<{
	teams: Team[];
}>();

const emit = defineEmits<{
	(e: 'update', id: number): void;
}>();

const currentTeam = defineModel<number | null>({ default: null });

const teamsOptions = computed(() => mapTeamsToComboboxOptions(toRef(props.teams)));

const setDefaultTeam = () => {
	if (currentTeam.value) {
		return;
	}

	if (props.teams && props.teams.length > 0) {
		currentTeam.value = props.teams[0].id;

		emit('update', props.teams[0].id);
	}
};

onMounted(setDefaultTeam);

watch(teamsOptions, setDefaultTeam);
</script>

<template>
	<Combobox
		:model-value="currentTeam"
		:options="teamsOptions"
		not-found-message="No team found"
		placeholder="Select team"
		@update:model-value="
			(value) => {
				currentTeam = value;
				$emit('update', value);
			}
		"
	/>
</template>
