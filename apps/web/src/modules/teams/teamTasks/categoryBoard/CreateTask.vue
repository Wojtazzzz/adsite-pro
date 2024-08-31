<script setup lang="ts">
import Button from '@/components/ui/Button.vue';
import type { Team } from '@/modules/teams/useGetUserTeams';
import { useBoolean } from '@/composables/useBoolean';
import Sheet from '@/components/ui/sheet/Sheet.vue';
import SheetTrigger from '@/components/ui/sheet/SheetTrigger.vue';
import SheetHeader from '@/components/ui/sheet/SheetHeader.vue';
import SheetTitle from '@/components/ui/sheet/SheetTitle.vue';
import SheetDescription from '@/components/ui/sheet/SheetDescription.vue';
import SheetContent from '@/components/ui/sheet/SheetContent.vue';
import SheetFooter from '@/components/ui/sheet/SheetFooter.vue';
import IconPlus from '@/components/icons/IconPlus.vue';
import Field from '@/components/ui/form/Field.vue';
import Form from '@/components/ui/form/Form.vue';
import {
	createTaskFormSchema,
	type CreateTaskFormData,
	taskStatusOptions,
	mapUsersToSelectOptions,
} from '@/modules/teams/teamTasks/categoryBoard/utils';
import Textarea from '@/components/ui/Textarea.vue';
import Select from '@/components/ui/Select.vue';
import { useCreateTask } from '@/modules/teams/teamTasks/categoryBoard/useCreateTask';
import Number from '@/components/ui/number/Number.vue';
import { useGetTeamMembers } from '@/modules/teams/teamTasks/categoryBoard/useGetTeamMembers';
import { computed, toRef } from 'vue';
import type { Category } from '@/modules/teams/teamTasks/useGetTeamTasks';
import type { TaskStatus } from '@/utils/schemas';

const props = defineProps<{
	team: Team;
	category: Category;
	defaultStatus: TaskStatus;
}>();

const { state: isOpen, setTrue: open, setFalse: close } = useBoolean();

const { createTask } = useCreateTask();

const onSubmit = (values: CreateTaskFormData) => {
	createTask(
		{
			teamId: props.team.id,
			categoryId: props.category.id,
			name: values.name,
			description: values.description,
			status: values.status,
			userId: values.userId,
			estimation: values.estimation,
		},
		close,
	);
};

const { users } = useGetTeamMembers(computed(() => props.team));
const userOptions = computed(() => mapUsersToSelectOptions(toRef(users.value?.data)));
</script>

<template>
	<Sheet :open="isOpen">
		<SheetTrigger as-child>
			<Button type="button" @click="open">
				<span class="sr-only">Create task</span>
				<IconPlus />
			</Button>
		</SheetTrigger>
		<SheetContent
			@escapeKeyDown="close"
			@focusOutside="close"
			@interactOutside="close"
			@pointerDownOutside="close"
			:closeClick="close"
		>
			<Form :schema="createTaskFormSchema" :on-submit="onSubmit">
				<SheetHeader>
					<SheetTitle>Create task</SheetTitle>
					<SheetDescription>
						Create task and assign it to your team member.
					</SheetDescription>
				</SheetHeader>

				<div class="space-y-4 mt-6">
					<Field type="text" name="name" label="Name" placeholder="Chop onions" />

					<Textarea
						name="description"
						label="Description"
						placeholder="Be careful! The knife can be sharp..."
					/>

					<Select
						:value="defaultStatus"
						:options="taskStatusOptions"
						name="status"
						label="Status"
					/>

					<Select :options="userOptions" name="userId" label="User" />

					<Number name="estimation" label="Estimation (minutes)" />

					<div class="flex justify-end">
						<SheetFooter>
							<Button type="submit">Save changes</Button>
						</SheetFooter>
					</div>
				</div>
			</Form>
		</SheetContent>
	</Sheet>
</template>
