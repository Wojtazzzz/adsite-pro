<script setup lang="ts">
import Combobox from '@/components/ui/Combobox.vue';
import { useGetMemberTeams } from '@/modules/tasks/selectTeam/useGetMemberTeams';
import { computed, onMounted, ref, watch } from 'vue';
import { mapTeamsToComboboxOptions } from '@/modules/tasks/utils';

const emit = defineEmits<{
	(e: 'update', id: number): void;
}>();

const currentTeam = ref<number | null>(null);

const { data } = useGetMemberTeams();

const teamsOptions = computed(() => mapTeamsToComboboxOptions(data));

const setDefaultTeam = () => {
	if (currentTeam.value) {
		return;
	}

	if (data.value && data.value.data.length > 0) {
		currentTeam.value = data.value.data[0].id;

		emit('update', data.value.data[0].id);
	}
};

onMounted(setDefaultTeam);

watch(data, setDefaultTeam);
</script>

<template>
	<Combobox
		:model-value="currentTeam"
		:options="teamsOptions"
		not-found-message="No team found"
		placeholder="Select team"
		@update:model-value="({ value }) => $emit('update', value)"
	/>
</template>
