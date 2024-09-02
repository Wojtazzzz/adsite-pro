<script setup lang="ts">
import CardTitle from '@/components/ui/card/CardTitle.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import Card from '@/components/ui/card/Card.vue';
import type { Category, Task } from '@/modules/teams/teamTasks/useGetTeamTasks';
import { type RenameTeamFormValues } from '@/modules/teams/manageTeam/utils';
import DialogTrigger from '@/components/ui/card/dialog/DialogTrigger.vue';
import DialogContent from '@/components/ui/card/dialog/DialogContent.vue';
import DialogTitle from '@/components/ui/card/dialog/DialogTitle.vue';
import Button from '@/components/ui/Button.vue';
import DialogDescription from '@/components/ui/card/dialog/DialogDescription.vue';
import Dialog from '@/components/ui/card/dialog/Dialog.vue';
import DialogHeader from '@/components/ui/card/dialog/DialogHeader.vue';
import IconPencil from '@/components/icons/IconPencil.vue';
import { useBoolean } from '@/composables/useBoolean';
import {
	formatTaskEstimation,
	taskStatusOptions,
} from '@/modules/teams/teamTasks/categoryBoard/utils';
import Select from '@/components/ui/Select.vue';
import { toRef, watch } from 'vue';
import { useChangeTaskStatus } from '@/modules/teams/teamTasks/categoryBoard/useChangeTaskStatus';

const props = defineProps<{
	task: Task;
	category: Category;
}>();

const { state: isOpen, setTrue: open, setFalse: close } = useBoolean();
const { changeStatus } = useChangeTaskStatus();

const status = toRef(props.task.status);

watch(status, () => {
	if (status.value !== props.task.status) {
		changeStatus({
			teamId: props.category.team_id,
			categoryId: props.task.category_id,
			id: props.task.id,
			newStatus: status.value,
		});
	}
});
</script>

<template>
	<Card>
		<CardHeader class="p-4">
			<CardTitle tag="h3">
				{{ task.name }}
			</CardTitle>

			<div class="w-full flex justify-end">
				<Dialog :open="isOpen">
					<DialogTrigger>
						<Button type="button" @click="open">
							<span class="sr-only">Rename team</span>
							<IconPencil />
						</Button>
					</DialogTrigger>
					<DialogContent
						vertical-position="center"
						@closeClick="close"
						@escapeKeyDown="close"
						@focusOutside="close"
						@interactOutside="close"
						@pointerDownOutside="close"
					>
						<DialogHeader>
							<DialogTitle>
								<span>{{ task.name }}</span>
							</DialogTitle>
							<DialogDescription>
								<div class="mt-6 space-y-1.5">
									<p>
										<span class="font-semibold">Description: &nbsp;</span>
										<span>{{ task.description }}</span>
									</p>
									<p>
										<span class="font-semibold">Estimation: &nbsp;</span>
										<span>{{ formatTaskEstimation(task.estimation) }}</span>
									</p>
									<p>
										<span class="font-semibold">User: &nbsp;</span>
										<span>{{ task.user.name }}</span>
									</p>
									<div>
										<label>
											<span class="font-semibold mb-1.5 block">Status:</span>

											<Select
												v-model="status"
												:options="taskStatusOptions"
												name="status"
												label="Status:"
											/>
										</label>
									</div>
								</div>
							</DialogDescription>
						</DialogHeader>
					</DialogContent>
				</Dialog>
			</div>
		</CardHeader>
	</Card>
</template>
