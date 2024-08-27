<script setup lang="ts">
import type { Category, Task } from '@/modules/tasks/teamTasks/useGetTasks';
import { computed, ref, toRaw } from 'vue';
import { useChangeTaskStatus } from '@/modules/tasks/teamTasks/categoryBoard/useChangeTaskStatus';
import CategoryBox from '@/modules/tasks/teamTasks/categoryBoard/CategoryBox.vue';
import TaskBox from '@/modules/tasks/teamTasks/categoryBoard/TaskBox.vue';
import Draggable from '@/components/ui/dragAndDrop/Draggable.vue';
import Droppable from '@/components/ui/dragAndDrop/Droppable.vue';

const props = defineProps<{
	category: Category;
}>();

const { changeStatus } = useChangeTaskStatus();

const tasks = ref(toRaw(props.category.tasks));
const idleTasks = computed(() => tasks.value.filter((task) => task.status === 'IDLE'));
const inProgressTasks = computed(() => tasks.value.filter((task) => task.status === 'IN_PROGRESS'));
const completedTasks = computed(() => tasks.value.filter((task) => task.status === 'COMPLETED'));

const onDrop = (event: DragEvent, type: 'IDLE' | 'IN_PROGRESS' | 'COMPLETED') => {
	const taskId = Number(event.dataTransfer?.getData('task-id'));
	const from = event.dataTransfer?.getData('from') as 'IDLE' | 'IN_PROGRESS' | 'COMPLETED';

	if (from === type) {
		return;
	}

	const task = tasks.value.find((task) => task.id === taskId);

	if (task) {
		task.status = type;

		changeStatus({
			id: task.id,
			newStatus: task.status,
		});
	}
};

const onDragStart = (event: DragEvent, task: Task) => {
	if (!event.dataTransfer) {
		return;
	}

	event.dataTransfer.setData('task-id', String(task.id));
	event.dataTransfer.setData('from', task.status);
};
</script>

<template>
	<div class="flex w-full justify-evenly gap-x-8">
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
