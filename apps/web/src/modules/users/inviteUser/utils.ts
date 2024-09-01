import * as z from 'zod';

export const inviteUserFormSchema = z.object({
	email: z.string({
		message: 'This field is required.',
	}),
});

export type InviteUserFormData = z.infer<typeof inviteUserFormSchema>;
