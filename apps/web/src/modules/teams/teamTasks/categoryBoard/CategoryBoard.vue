<script setup lang="ts">
import type { Category } from '@/modules/teams/teamTasks/useGetTeamTasks';
import TaskBox from '@/modules/teams/teamTasks/categoryBoard/TaskBox.vue';
import Draggable from '@/components/ui/dragAndDrop/Draggable.vue';
import Droppable from '@/components/ui/dragAndDrop/Droppable.vue';
import { useCategoryBoard } from '@/modules/teams/teamTasks/categoryBoard/useCategoryBoard';
import { computed, toValue } from 'vue';
import StatusBox from '@/modules/teams/teamTasks/categoryBoard/StatusBox.vue';
import type { Team } from '@/modules/teams/useGetUserTeams';
import CreateTask from '@/modules/teams/teamTasks/categoryBoard/CreateTask.vue';

const props = defineProps<{
	team: Team;
	category: Category;
}>();

const { idleTasks, inProgressTasks, completedTasks, onDragStart, onDrop } = useCategoryBoard(
	computed(() => props.category),
);

const statuses = computed(
	() =>
		[
			{ key: 'IDLE', name: 'Idle', tasks: toValue(idleTasks) },
			{ key: 'IN_PROGRESS', name: 'In progress', tasks: toValue(inProgressTasks) },
			{ key: 'COMPLETED', name: 'Completed', tasks: toValue(completedTasks) },
		] as const,
);
</script>

<template>
	<div class="flex w-full justify-center gap-8">
		<template v-for="status in statuses" :key="status.key">
			<StatusBox :status-name="status.name">
				<Droppable as="ul" @dragover.prevent @drop.prevent="onDrop($event, status.key)">
					<template v-for="task in status.tasks" :key="task.id">
						<Draggable as="li" @dragstart="onDragStart($event, task)">
							<TaskBox :task-name="task.name" />
						</Draggable>
					</template>
				</Droppable>

				<template #options v-if="team.isOwner">
					<CreateTask :team="team" :category="category" :default-status="status.key" />
				</template>
			</StatusBox>
		</template>
	</div>
</template>
