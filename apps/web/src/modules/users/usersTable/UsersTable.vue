<script setup lang="ts">
import TableCell from '@/components/ui/table/TableCell.vue';
import TableHead from '@/components/ui/table/TableHead.vue';
import Table from '@/components/ui/table/Table.vue';
import TableRow from '@/components/ui/table/TableRow.vue';
import TableCaption from '@/components/ui/table/TableCaption.vue';
import TableHeader from '@/components/ui/table/TableHeader.vue';
import TableBody from '@/components/ui/table/TableBody.vue';
import type { User } from '@/modules/users/useGetTeamMembersDetails';
import DeleteTeamMember from '@/modules/users/usersTable/DeleteTeamMember.vue';
import { useGetTeamId } from '@/modules/users/useGetTeamId';
import { useMe } from '@/composables/useMe';

defineProps<{
	users: User[];
}>();

const { user: loggedUser } = useMe();
const teamId = useGetTeamId();
</script>

<template>
	<div class="relative">
		<Table>
			<TableCaption>A list of your team members.</TableCaption>
			<TableHeader>
				<TableRow>
					<TableHead class="w-[100px]">ID</TableHead>
					<TableHead>Name</TableHead>
					<TableHead>Tasks (idle / in progress / completed)</TableHead>
					<TableHead>Overloading (minutes)</TableHead>
					<TableHead class="text-right">Options</TableHead>
				</TableRow>
			</TableHeader>
			<TableBody>
				<TableRow v-for="user in users" :key="user.id">
					<TableCell>
						{{ user.id }}
					</TableCell>
					<TableCell>
						{{ user.name }}
						<template v-if="loggedUser?.id === user.id">
							<span>(you)</span>
						</template>
					</TableCell>
					<TableCell>
						{{ user.tasks_count }}
						&nbsp; ({{ user.idle_tasks_count }}
						/
						{{ user.in_progress_tasks_count }}
						/
						{{ user.completed_tasks_count }})
					</TableCell>
					<TableCell>
						{{ user.total_estimation }}
						/ 9600
					</TableCell>
					<TableCell class="text-right">
						<template v-if="loggedUser?.id !== user.id">
							<DeleteTeamMember :team-id="teamId" :user-id="user.id" />
						</template>
					</TableCell>
				</TableRow>
			</TableBody>
		</Table>
	</div>
</template>
