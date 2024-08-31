import { z } from 'zod';
import { teamNameSchema } from '@/utils/schemas';

export const createTeamFormSchema = z.object({
	name: teamNameSchema,
});

export type CreateTeamFormData = z.infer<typeof createTeamFormSchema>;
