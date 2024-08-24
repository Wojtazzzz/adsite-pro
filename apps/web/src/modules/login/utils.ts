import * as z from 'zod';

export const loginFormSchema = z.object({
	email: z
		.string({
			message: 'This field is required.',
		})
		.email('Invalid email address.'),
	password: z.string({
		message: 'This field is required.',
	}),
});

export type LoginFormData = z.infer<typeof loginFormSchema>;
