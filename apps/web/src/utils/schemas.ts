import { z } from 'zod';

export const responseErrorSchema = z.object({
	response: z.object({
		data: z.object({
			message: z.string({}),
		}),
	}),
});

export const teamNameSchema = z.string().min(5, 'Name should be more than 5 characters');
