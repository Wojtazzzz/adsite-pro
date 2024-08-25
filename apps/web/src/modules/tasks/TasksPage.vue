<script setup lang="ts">
import Container from '@/components/ui/Container.vue';
import { useGetTasks } from '@/modules/tasks/useGetTasks';
import Combobox from '@/components/ui/Combobox.vue';
import { computed, ref } from 'vue';
import { mapTeamsToComboboxOptions } from '@/modules/tasks/utils';

const { data } = useGetTasks();
const teamsOptions = computed(() => mapTeamsToComboboxOptions(data));

const currentTeam = ref(null);
</script>

<template>
	<Container>
		<Combobox
			:model-value="currentTeam"
			:options="teamsOptions"
			not-found-message="No team found"
			placeholder="Select team"
		/>
	</Container>
</template>
