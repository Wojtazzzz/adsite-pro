<script setup lang="ts">
import Container from '@/components/ui/Container.vue';
import { useGetTasks } from '@/modules/tasks/useGetTasks';
import Combobox from '@/components/ui/Combobox.vue';
import Button from '@/components/ui/Button.vue';
import { computed, ref } from 'vue';
import { mapTeamsToComboboxOptions } from '@/modules/tasks/utils';
import Tabs from '@/components/ui/tabs/Tabs.vue';
import TabsList from '@/components/ui/tabs/TabsList.vue';
import TabTrigger from '@/components/ui/tabs/TabsTrigger.vue';
import TabsContent from '@/components/ui/tabs/TabsContent.vue';
import CategoryTasks from '@/modules/tasks/CategoryTasks.vue';

const { data } = useGetTasks();
const teamsOptions = computed(() => mapTeamsToComboboxOptions(data));

const currentTeam = ref(null);
</script>

<template>
	<Container>
		<div>
			<Combobox
				:model-value="currentTeam"
				:options="teamsOptions"
				not-found-message="No team found"
				placeholder="Select team"
			/>
		</div>

		<template v-if="data">
			<div class="mt-6">
				<Tabs :default-tab="data.data[0].categories[0].id">
					<TabsList>
						<template v-for="category in data.data[0].categories" :key="category.id">
							<TabTrigger :value="category.id">
								<Button type="button">{{ category.name }}</Button>
							</TabTrigger>
						</template>
					</TabsList>

					<template v-for="category in data.data[0].categories" :key="category.id">
						<TabsContent :value="category.id">
							<CategoryTasks :category="category" />
						</TabsContent>
					</template>
				</Tabs>
			</div>
		</template>
	</Container>
</template>
