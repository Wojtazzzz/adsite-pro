import { z } from 'zod';

export const responseErrorSchema = z.object({
	response: z.object({
		data: z.object({
			message: z.string({}),
		}),
	}),
});

export const teamNameSchema = z.string().min(5, 'Name should be more than 5 characters');

export const taskStatusSchema = z.enum(['IDLE', 'IN_PROGRESS', 'COMPLETED'] as const);
export type TaskStatus = z.infer<typeof taskStatusSchema>;
