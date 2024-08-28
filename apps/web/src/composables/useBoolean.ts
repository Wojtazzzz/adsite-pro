import { ref } from 'vue';

export const useBoolean = (defaultValue = false) => {
	const state = ref(defaultValue);

	const setTrue = () => {
		state.value = true;
	};

	const setFalse = () => {
		state.value = false;
	};

	const toggle = () => {
		state.value = !state.value;
	};

	const setCustom = (newState: boolean) => {
		state.value = newState;
	};

	return {
		state,
		setTrue,
		setFalse,
		toggle,
		setCustom,
	};
};
