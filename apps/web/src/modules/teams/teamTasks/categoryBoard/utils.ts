import * as z from 'zod';
import { type TaskStatus, taskStatusSchema } from '@/utils/schemas';
import type { SelectOption } from '@/components/ui/form/Select.vue';
import type { Ref } from 'vue';

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

export const formatTaskEstimation = (estimation: number) => {
	if (estimation < 60) {
		return `${estimation} minutes`;
	}

	if (estimation % 60 === 0) {
		return `${estimation / 60} hour/s`;
	}

	const hours = Math.floor(estimation / 60);
	const minutes = estimation % 60;

	return `${hours} hour/s ${minutes} minutes`;
};

const userSchema = z.object({
	id: z.number(),
	name: z.string(),
});

export const getTeamMembersResponseSchema = z.object({
	data: z.array(userSchema),
});

export type User = z.infer<typeof userSchema>;
