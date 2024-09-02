import '@/assets/style.css';
import { createApp } from 'vue';
import App from './App.vue';
import { router } from '@/router';
import { VueQueryPlugin } from '@tanstack/vue-query';

const app = createApp(App);

app.use(VueQueryPlugin, {
	queryClientConfig: {
		defaultOptions: {
			queries: {
				retry: 0,
				staleTime: 1000 * 10,
			},
		},
	},
});
app.use(router);

app.mount('#app');
