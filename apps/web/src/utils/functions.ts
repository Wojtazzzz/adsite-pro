import { type ClassValue, clsx } from 'clsx';
import { twMerge } from 'tailwind-merge';
import Axios from 'axios';
import { VITE_API_URL } from '@/utils/env';

export function cn(...inputs: ClassValue[]) {
	return twMerge(clsx(inputs));
}

const axios = Axios.create({
	baseURL: VITE_API_URL,
	withCredentials: true,
	xsrfCookieName: 'XSRF-TOKEN',
	xsrfHeaderName: 'X-XSRF-TOKEN',
	withXSRFToken: true,
	headers: {
		"Content-Type": 'application/json',
		Accept: 'application/json',
		"X-Requested-With": "XMLHttpRequest"
	}
});

type ApiCallOptions =
	| {
			url: string;
			method: 'GET' | 'DELETE';
	  }
	| {
			url: string;
			method: 'POST' | 'PUT' | 'PATCH';
			payload?: string | number | object;
	  };

export const api = async (options: ApiCallOptions) => {
	await axios.get('/sanctum/csrf-cookie');

	if (options.method === 'PATCH') {
		return axios.patch(options.url, options.payload);
	}

	if (options.method === 'POST') {
		return axios.post(options.url, options.payload);
	}

	if (options.method === 'PUT') {
		return axios.put(options.url);
	}

	if (options.method === 'DELETE') {
		return axios.delete(options.url);
	}

	return axios.get(options.url);
};
