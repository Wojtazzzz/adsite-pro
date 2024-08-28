<script setup lang="ts">
import type { Category } from '@/modules/tasks/teamTasks/useGetTasks';
import TaskBox from '@/modules/tasks/teamTasks/categoryBoard/TaskBox.vue';
import Draggable from '@/components/ui/dragAndDrop/Draggable.vue';
import Droppable from '@/components/ui/dragAndDrop/Droppable.vue';
import { useCategoryBoard } from '@/modules/tasks/teamTasks/categoryBoard/useCategoryBoard';
import { computed, toValue } from 'vue';
import StatusBox from '@/modules/tasks/teamTasks/categoryBoard/StatusBox.vue';

const props = defineProps<{
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
			</StatusBox>
		</template>
	</div>
</template>
