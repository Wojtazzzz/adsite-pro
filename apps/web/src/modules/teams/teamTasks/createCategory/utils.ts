import { z } from 'zod';

export const createCategorySchema = z.object({
	name: z.string().min(3),
});

export type CreateCategoryFormValues = z.infer<typeof createCategorySchema>;
