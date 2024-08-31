import * as z from 'zod';

export const registerFormSchema = z
	.object({
		name: z
			.string({
				message: 'This field is required.',
			})
			.min(4, 'Name must contain at least 4 character(s)'),
		email: z
			.string({
				message: 'This field is required.',
			})
			.email('Invalid email address.'),
		password_confirmation: z.string({
			message: 'This field is required.',
		}),
		password: z.string({
			message: 'This field is required.',
		}),
	})
	.refine((data) => data.password === data.password_confirmation, {
		message: "Passwords don't match",
		path: ['password_confirmation'],
	});

export type RegisterFormData = z.infer<typeof registerFormSchema>;
