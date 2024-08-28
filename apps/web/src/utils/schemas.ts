import { z } from 'zod';

export const responseErrorSchema = z.object({
	response: z.object({
		data: z.object({
			message: z.string({}),
		}),
	}),
});
