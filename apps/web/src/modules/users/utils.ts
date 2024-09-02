import { z } from 'zod';

const teamMemberDetailsSchema = z.object({
	id: z.number(),
	name: z.string(),
	tasksCount: z.number(),
	idleTasksCount: z.number(),
	inProgressTasksCount: z.number(),
	completedTasksCount: z.number(),
	totalEstimation: z.number(),
});
export const getTeamMembersDetailsResponseSchema = z.object({
	data: z.array(teamMemberDetailsSchema),
});

export type TeamMemberDetails = z.infer<typeof teamMemberDetailsSchema>;
