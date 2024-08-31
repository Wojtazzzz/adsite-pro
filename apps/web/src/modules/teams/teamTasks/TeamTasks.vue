<script setup lang="ts">
import Button from '@/components/ui/Button.vue';
import CategoryBoard from '@/modules/teams/teamTasks/categoryBoard/CategoryBoard.vue';
import TabsContent from '@/components/ui/tabs/TabsContent.vue';
import TabsList from '@/components/ui/tabs/TabsList.vue';
import TabTrigger from '@/components/ui/tabs/TabsTrigger.vue';
import Tabs from '@/components/ui/tabs/Tabs.vue';
import { useGetTeamTasks } from '@/modules/teams/teamTasks/useGetTeamTasks';
import { computed } from 'vue';
import SpinnerLoader from '@/components/ui/SpinnerLoader.vue';
import Alert from '@/components/ui/Alert.vue';
import type { Team } from '@/modules/teams/useGetUserTeams';

const props = defineProps<{
	team: Team;
}>();

const { tasks, isLoading, isError } = useGetTeamTasks(computed(() => props.team));
</script>

<template>
	<template v-if="isLoading">
		<SpinnerLoader />
	</template>
	<template v-else-if="isError || !tasks?.data">
		<Alert variant="destructive">Something went wrong on the server</Alert>
	</template>
	<template v-else-if="tasks.data.categories.length <= 0">
		<Alert variant="default">Your team has no task categories</Alert>
	</template>
	<template v-else>
		<Tabs :default-tab="1">
			<div class="w-full space-y-8">
				<TabsList>
					<template v-for="category in tasks.data.categories" :key="category.id">
						<TabTrigger :value="category.id">
							<Button type="button">{{ category.name }}</Button>
						</TabTrigger>
					</template>
				</TabsList>

				<template v-for="category in tasks.data.categories" :key="category.id">
					<TabsContent :value="category.id">
						<CategoryBoard :category="category" />
					</TabsContent>
				</template>
			</div>
		</Tabs>
	</template>
</template>
