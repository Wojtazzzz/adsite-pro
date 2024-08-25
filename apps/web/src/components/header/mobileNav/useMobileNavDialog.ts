import { useBoolean } from '@/composables/useBoolean';

export const useMobileNavDialog = () => {
	const { state, setTrue, setFalse } = useBoolean();

	return {
		isOpen: state,
		open: setTrue,
		close: setFalse,
	};
};
