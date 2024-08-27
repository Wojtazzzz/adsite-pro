<script setup lang="ts">
import type { Category, Task } from '@/modules/tasks/teamTasks/useGetTasks';
import { computed, ref, toRaw } from 'vue';
import { useChangeTaskStatus } from '@/modules/tasks/teamTasks/categoryBoard/useChangeTaskStatus';
import Card from '@/components/ui/card/Card.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CategoryBox from '@/modules/tasks/teamTasks/categoryBoard/CategoryBox.vue';
import TaskBox from '@/modules/tasks/teamTasks/categoryBoard/TaskBox.vue';

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
			<ul
				class="min-w-64 min-h-64 space-y-4"
				@drop.prevent="onDrop($event, 'IDLE')"
				@dragover.prevent
			>
				<template v-for="task in idleTasks" :key="task.id">
					<li draggable="true" @dragstart="onDragStart($event, task)">
						<TaskBox :task-name="task.name" />
					</li>
				</template>
			</ul>
		</CategoryBox>

		<CategoryBox category-name="in progress">
			<ul
				class="min-w-64 min-h-64 space-y-4"
				@drop.prevent="onDrop($event, 'IN_PROGRESS')"
				@dragover.prevent
			>
				<template v-for="task in inProgressTasks" :key="task.id">
					<li draggable="true" @dragstart="onDragStart($event, task)">
						<TaskBox :task-name="task.name" />
					</li>
				</template>
			</ul>
		</CategoryBox>

		<CategoryBox category-name="completed">
			<ul
				class="min-w-64 min-h-64 space-y-4"
				@drop.prevent="onDrop($event, 'COMPLETED')"
				@dragover.prevent
			>
				<template v-for="task in completedTasks" :key="task.id">
					<li draggable="true" @dragstart="onDragStart($event, task)">
						<TaskBox :task-name="task.name" />
					</li>
				</template>
			</ul>
		</CategoryBox>
	</div>
</template>
