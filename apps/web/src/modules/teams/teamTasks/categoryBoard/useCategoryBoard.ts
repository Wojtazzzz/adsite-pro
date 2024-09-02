import { useChangeTaskStatus } from '@/modules/teams/teamTasks/categoryBoard/useChangeTaskStatus';
import { computed, type ComputedRef } from 'vue';
import type { Category, Task } from '@/modules/teams/teamTasks/utils';

export const useCategoryBoard = (category: ComputedRef<Category>) => {
	const { changeStatus } = useChangeTaskStatus();

	const idleTasks = computed(() => {
		return category.value.tasks.filter((task) => task.status === 'IDLE');
	});

	const inProgressTasks = computed(() => {
		return category.value.tasks.filter((task) => task.status === 'IN_PROGRESS');
	});
	const completedTasks = computed(() => {
		return category.value.tasks.filter((task) => task.status === 'COMPLETED');
	});

	const onDrop = (event: DragEvent, type: 'IDLE' | 'IN_PROGRESS' | 'COMPLETED') => {
		if (!event.dataTransfer) {
			return;
		}

		const taskId = Number(event.dataTransfer.getData('taskId'));
		const from = event.dataTransfer.getData('from');

		if (!['IDLE', 'IN_PROGRESS', 'COMPLETED'].includes(from) || isNaN(taskId)) {
			return;
		}

		if (from === type) {
			return;
		}

		const task = category.value.tasks.find((task) => task.id === taskId);

		if (!task) {
			return;
		}

		changeStatus({
			id: taskId,
			categoryId: category.value.id,
			teamId: category.value.teamId,
			newStatus: type,
		});
	};

	const onDragStart = (event: DragEvent, task: Task) => {
		if (!event.dataTransfer) {
			return;
		}

		event.dataTransfer.setData('taskId', String(task.id));
		event.dataTransfer.setData('from', task.status);
	};

	return {
		idleTasks,
		inProgressTasks,
		completedTasks,
		onDrop,
		onDragStart,
	};
};
