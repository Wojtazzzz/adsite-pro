import { createRouter, createWebHistory } from 'vue-router';
import AuthLayout from '@/components/layouts/AuthLayout.vue';
import LoginPage from '@/modules/login/LoginPage.vue';
import RegisterPage from '@/modules/register/RegisterPage.vue';
import MainLayout from '@/components/layouts/MainLayout.vue';
import HomePage from '@/modules/home/HomePage.vue';
import axios from 'axios';
import { useQuery, useQueryClient } from '@tanstack/vue-query';
import { api } from '@/utils/functions';

export const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	routes: [
		{
			path: '/',
			component: MainLayout,
			children: [
				{
					path: '',
					name: 'home',
					component: HomePage,
				},
			],
		},
		{
			path: '/',
			component: AuthLayout,
			children: [
				{
					path: 'login',
					name: 'login',
					component: LoginPage,
				},
				{
					path: 'register',
					name: 'register',
					component: RegisterPage,
				},
			],
		},
	],
});

const onlyAuthRoutes = ['/my-teams'];
const onlyGuestRoutes = ['/login', '/register'];

router.beforeEach(async (to, from) => {
	const queryClient = useQueryClient();

	await queryClient.prefetchQuery({
		queryKey: ['me'],
		queryFn: async () => {
			return await api({
				url: '/api/me',
				method: 'GET',
			});
		},
	});

	const data = queryClient.getQueryState(['me']);

	if (onlyAuthRoutes.includes(to.path)) {
		if (!data || data.status === 'error') {
			return {
				name: 'login',
			};
		}
	}

	if (onlyGuestRoutes.includes(to.path)) {
		if (data && data.status !== 'error') {
			return {
				name: 'home',
			};
		}
	}
});
