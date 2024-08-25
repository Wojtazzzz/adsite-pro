import { createRouter, createWebHistory } from 'vue-router';
import AuthLayout from '@/components/layouts/AuthLayout.vue';
import LoginPage from '@/modules/login/LoginPage.vue';
import RegisterPage from '@/modules/register/RegisterPage.vue';
import MainLayout from '@/components/layouts/MainLayout.vue';
import HomePage from '@/modules/home/HomePage.vue';

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
