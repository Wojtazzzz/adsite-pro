import { z } from 'zod';
import { taskStatusSchema } from '@/utils/schemas';

const taskUserSchema = z.object({
	id: z.number(),
	name: z.string(),
});

const taskSchema = z.object({
	id: z.number(),
	categoryId: z.number(),
	userId: z.number(),
	name: z.string(),
	description: z.string(),
	estimation: z.number(),
	status: taskStatusSchema,
	createdAt: z.string(),
	user: taskUserSchema,
});

const categorySchema = z.object({
	id: z.number(),
	name: z.string(),
	teamId: z.number(),
	tasks: z.array(taskSchema),
});

export const getTeamTasksResponseSchema = z.object({
	data: z.object({
		id: z.number(),
		name: z.string(),
		categories: z.array(categorySchema),
	}),
});

export type Category = z.infer<typeof categorySchema>;
export type Task = z.infer<typeof taskSchema>;
export type TaskUser = z.infer<typeof taskUserSchema>;
