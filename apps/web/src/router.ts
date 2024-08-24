import { createRouter, createWebHistory } from 'vue-router'
import LoginPage from '@/modules/login/LoginPage.vue'

export const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'login',
            component: LoginPage
        }
    ]
});
