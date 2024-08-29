import { useToast } from '@/composables/useToast';
import { useMutation } from '@tanstack/vue-query';
import { responseErrorSchema } from '@/utils/schemas';

type UseMutateOptions<Payload> = {
	apiCall: (payload: Payload) => Promise<unknown>;
	onSuccess?: () => Promise<unknown> | unknown;
	onSettled?: () => Promise<unknown> | unknown;
	toastErrors: boolean;
};

export const useMutate = <Payload>({
	apiCall,
	onSuccess,
	onSettled,
	toastErrors,
}: UseMutateOptions<Payload>) => {
	const { callToast } = useToast();

	const {
		mutate: callMutate,
		isError,
		error,
	} = useMutation({
		mutationFn: async (payload: Payload) => {
			return apiCall(payload);
		},
		async onSuccess() {
			if (onSuccess) {
				return onSuccess();
			}
		},
		async onSettled() {
			if (onSettled) {
				return onSettled();
			}
		},
		async onError(error) {
			if (!toastErrors) {
				return;
			}
			const { success, data } = await responseErrorSchema.safeParseAsync(error);

			if (success) {
				return callToast({
					title: 'Error!',
					description: data.response.data.message,
				});
			}

			return callToast({
				title: 'Error!',
				description: 'Something went wrong',
			});
		},
	});

	const mutate = (payload: Payload, onSuccess?: () => void) => {
		callMutate(payload, {
			onSuccess() {
				if (onSuccess) {
					onSuccess();
				}
			},
		});
	};

	return {
		isError,
		error,
		mutate,
	};
};
