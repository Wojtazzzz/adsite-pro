<script setup lang="ts">
import Button from '@/components/ui/Button.vue';
import CategoryTasks from '@/modules/tasks/teamTasks/CategoryTasks.vue';
import TabsContent from '@/components/ui/tabs/TabsContent.vue';
import TabsList from '@/components/ui/tabs/TabsList.vue';
import TabTrigger from '@/components/ui/tabs/TabsTrigger.vue';
import Tabs from '@/components/ui/tabs/Tabs.vue';
import { useGetTasks } from '@/modules/tasks/teamTasks/useGetTasks';
import { computed } from 'vue';

const props = defineProps<{
	team: number;
}>();

const { data } = useGetTasks(computed(() => props.team));
</script>

<template>
	<template v-if="data">
		<Tabs :default-tab="1">
			<TabsList>
				<template v-for="category in data.data.categories" :key="category.id">
					<TabTrigger :value="category.id">
						<Button type="button">{{ category.name }}</Button>
					</TabTrigger>
				</template>
			</TabsList>

			<template v-for="category in data.data.categories" :key="category.id">
				<TabsContent :value="category.id">
					<CategoryTasks :category="category" />
				</TabsContent>
			</template>
		</Tabs>
	</template>
</template>
