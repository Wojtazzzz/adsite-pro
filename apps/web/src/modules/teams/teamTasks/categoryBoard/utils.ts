import * as z from 'zod';
import { type TaskStatus, taskStatusSchema } from '@/utils/schemas';
import type { SelectOption } from '@/components/ui/Select.vue';
import type { Ref } from 'vue';
import type { User } from '@/modules/teams/teamTasks/categoryBoard/useGetTeamMembers';

export const createTaskFormSchema = z.object({
	name: z
		.string({
			message: 'This field is required.',
		})
		.min(2)
		.max(128),
	description: z
		.string({
			message: 'This field is required.',
		})
		.min(2)
		.max(1028),
	status: taskStatusSchema,
	userId: z.preprocess((x) => Number(x), z.number()),
	estimation: z.number().min(15).max(9600),
});

export type CreateTaskFormData = z.infer<typeof createTaskFormSchema>;

export const taskStatusOptions = [
	{
		value: 'IDLE',
		label: 'Idle',
	},
	{
		value: 'IN_PROGRESS',
		label: 'In progress',
	},
	{
		value: 'COMPLETED',
		label: 'Completed',
	},
] as const satisfies SelectOption<TaskStatus>[];

export const mapUsersToSelectOptions = (users: Ref<User[] | undefined>) => {
	if (!users.value) {
		return [];
	}

	return users.value.map((user) => ({
		value: String(user.id),
		label: user.name,
	}));
};
