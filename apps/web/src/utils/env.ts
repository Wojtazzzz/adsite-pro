const invariant = (env: unknown, envName: string) => {
	if (!env || typeof env !== 'string') {
		throw new Error(`Invalid env variable "${envName}"`);
	}

	return env;
};

export const VITE_API_URL = invariant(import.meta.env.VITE_API_URL, 'VITE_API_URL');
