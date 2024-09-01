<script setup lang="ts">
import Container from '@/components/ui/Container.vue';
import { useGetTeamMembersDetails } from '@/modules/users/useGetTeamMembersDetails';
import SpinnerLoader from '@/components/ui/SpinnerLoader.vue';
import Alert from '@/components/ui/Alert.vue';
import InviteUser from '@/modules/users/inviteUser/InviteUser.vue';
import UsersTable from '@/modules/users/usersTable/UsersTable.vue';

const { users, isLoading, isError } = useGetTeamMembersDetails();
</script>

<template>
	<Container>
		<div class="space-y-6">
			<InviteUser />

			<template v-if="isLoading">
				<SpinnerLoader />
			</template>
			<template v-else-if="isError || !users?.data || users.data.length <= 0">
				<Alert variant="destructive">Something went wrong on the server</Alert>
			</template>
			<template v-else>
				<UsersTable :users="users.data" />
			</template>
		</div>
	</Container>
</template>
