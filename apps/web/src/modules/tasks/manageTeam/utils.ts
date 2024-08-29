import {z} from 'zod';
import {teamNameSchema} from '@/utils/schemas';

export const renameTeamSchema = z.object({
    name: teamNameSchema,
});

export type RenameTeamFormValues = z.infer<typeof renameTeamSchema>