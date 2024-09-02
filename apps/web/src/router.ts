import { createRouter, createWebHistory } from 'vue-router';
import AuthLayout from '@/components/layouts/AuthLayout.vue';
import LoginPage from '@/modules/login/LoginPage.vue';
import RegisterPage from '@/modules/register/RegisterPage.vue';
import MainLayout from '@/components/layouts/MainLayout.vue';
import HomePage from '@/modules/home/HomePage.vue';
import { useQueryClient } from '@tanstack/vue-query';
import { api } from '@/utils/functions';
import TeamsPage from '@/modules/teams/TeamsPage.vue';
import UsersPage from '@/modules/users/UsersPage.vue';

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
				{
					path: '/tasks',
					name: 'tasks',
					component: TeamsPage,
				},
				{
					path: '/users/:teamId',
					name: 'users',
					component: UsersPage,
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

const onlyAuthRoutes = ['/tasks'];
const onlyGuestRoutes = ['/login', '/register'];

router.beforeEach(async (to, from) => {
	if (to.path === from.path) {
		return true;
	}

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
