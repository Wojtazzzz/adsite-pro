import { z } from 'zod';

export const createTeamFormSchema = z.object({
	name: z.string().min(5, 'Name should be more than 5 characters'),
});

export type CreateTeamFormData = z.infer<typeof createTeamFormSchema>;

export const createTeamErrorSchema = z.object({
	response: z.object({
		data: z.object({
			message: z.string({}),
		}),
	}),
});
