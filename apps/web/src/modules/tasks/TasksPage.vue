<script setup lang="ts">
import Container from '@/components/ui/Container.vue';
import SelectTeam from '@/modules/tasks/selectTeam/SelectTeam.vue';
import { useTeams } from '@/modules/tasks/useTeams';
import TeamTasks from '@/modules/tasks/teamTasks/TeamTasks.vue';
import CreateTeam from '@/modules/tasks/createTeam/CreateTeam.vue';
import SpinnerLoader from '@/components/ui/SpinnerLoader.vue';
import Alert from '@/components/ui/Alert.vue';
import ManageTeam from '@/modules/tasks/manageTeam/ManageTeam.vue';

const { teams, isLoading, isError, currentTeam, updateTeam } = useTeams();
</script>

<template>
	<Container>
		<div class="w-full flex items-center justify-between">
			<SelectTeam :teams="teams?.data ?? []" @update="updateTeam" />

			<div class="flex justify-center items-center gap-x-3">
				<template v-if="currentTeam && currentTeam.isOwner">
					<ManageTeam :current-team="currentTeam" />
				</template>

				<CreateTeam />
			</div>
		</div>

		<div class="mt-8">
			<template v-if="isLoading">
				<SpinnerLoader />
			</template>
			<template v-else-if="isError || !teams?.data">
				<Alert variant="destructive" content="Something went wrong on the server" />
			</template>
			<template v-else-if="teams.data.length <= 0">
				<Alert
					variant="default"
					content="You have no teams to collaborate. Wait for an invitation or create your one."
				/>
			</template>
			<template v-else-if="currentTeam">
				<TeamTasks :team="currentTeam" />
			</template>
		</div>
	</Container>
</template>
