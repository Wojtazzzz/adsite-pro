<script setup lang="ts">
import Container from '@/components/ui/Container.vue';
import SelectTeam from '@/modules/tasks/selectTeam/SelectTeam.vue';
import { useCurrentTeam } from '@/modules/tasks/useCurrentTeam';
import TeamTasks from '@/modules/tasks/teamTasks/TeamTasks.vue';
import CreateTeam from '@/modules/tasks/createTeam/CreateTeam.vue';

const { currentTeam, updateTeam } = useCurrentTeam();
</script>

<template>
	<Container>
		<div class="w-full flex justify-between">
			<SelectTeam @update="updateTeam" />
			<CreateTeam />
		</div>

		<template v-if="currentTeam">
			<div class="mt-6">
				<TeamTasks :team="currentTeam" />
			</div>
		</template>
	</Container>
</template>
