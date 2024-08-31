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
import CreateCategory from '@/modules/teams/teamTasks/createCategory/CreateCategory.vue';
import IconPlus from '@/components/icons/IconPlus.vue';

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
		<Alert variant="default">
			<div>Your team has no task categories.</div>
			<template v-if="team.isOwner">
				<CreateCategory :teamId="team.id" v-slot:default="{ open }">
					<button type="button" class="underline" @click="open">Create category</button>
				</CreateCategory>
			</template>
		</Alert>
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

					<template v-if="team.isOwner">
						<CreateCategory :team-id="tasks.data.id" v-slot="{ open }">
							<Button type="button" @click="open">
								<span class="sr-only">Add category</span>
								<IconPlus />
							</Button>
						</CreateCategory>
					</template>
				</TabsList>

				<template v-for="category in tasks.data.categories" :key="category.id">
					<TabsContent :value="category.id">
						<CategoryBoard :team="team" :category="category" />
					</TabsContent>
				</template>
			</div>
		</Tabs>
	</template>
</template>
