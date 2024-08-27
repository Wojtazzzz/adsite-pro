<script setup lang="ts">
import type { Category } from '@/modules/tasks/teamTasks/useGetTasks';
import CategoryBox from '@/modules/tasks/teamTasks/categoryBoard/CategoryBox.vue';
import TaskBox from '@/modules/tasks/teamTasks/categoryBoard/TaskBox.vue';
import Draggable from '@/components/ui/dragAndDrop/Draggable.vue';
import Droppable from '@/components/ui/dragAndDrop/Droppable.vue';
import { useCategoryBoard } from '@/modules/tasks/teamTasks/categoryBoard/useCategoryBoard';
import { computed } from 'vue';

const props = defineProps<{
	category: Category;
}>();

const { idleTasks, inProgressTasks, completedTasks, onDragStart, onDrop } = useCategoryBoard(
	computed(() => props.category),
);
</script>

<template>
	<div class="flex w-full justify-center gap-8">
		<CategoryBox category-name="idle tasks">
			<Droppable as="ul" @dragover.prevent @drop.prevent="onDrop($event, 'IDLE')">
				<template v-for="task in idleTasks" :key="task.id">
					<Draggable as="li" @dragstart="onDragStart($event, task)">
						<TaskBox :task-name="task.name" />
					</Draggable>
				</template>
			</Droppable>
		</CategoryBox>

		<CategoryBox category-name="in progress">
			<Droppable as="ul" @dragover.prevent @drop.prevent="onDrop($event, 'IN_PROGRESS')">
				<template v-for="task in inProgressTasks" :key="task.id">
					<Draggable as="li" @dragstart="onDragStart($event, task)">
						<TaskBox :task-name="task.name" />
					</Draggable>
				</template>
			</Droppable>
		</CategoryBox>

		<CategoryBox category-name="completed">
			<Droppable as="ul" @dragover.prevent @drop.prevent="onDrop($event, 'COMPLETED')">
				<template v-for="task in completedTasks" :key="task.id">
					<Draggable as="li" @dragstart="onDragStart($event, task)">
						<TaskBox :task-name="task.name" />
					</Draggable>
				</template>
			</Droppable>
		</CategoryBox>
	</div>
</template>
