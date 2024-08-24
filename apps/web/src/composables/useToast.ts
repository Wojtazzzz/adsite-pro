import { toast } from '@/components/ui-library/toast';
import type { StringOrVNode } from '@/components/ui-library/toast/use-toast';

export const useToast = () => {
	const callToast = ({ title, description }: { title: string; description?: StringOrVNode }) => {
		toast({
			title,
			description,
		});
	};

	return {
		callToast,
	};
};
