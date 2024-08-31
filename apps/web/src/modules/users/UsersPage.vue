<script setup lang="ts">
import Container from '@/components/ui/Container.vue';
import { useGetTeamMembersDetails } from '@/modules/users/useGetTeamMembersDetails';
import SpinnerLoader from '@/components/ui/SpinnerLoader.vue';
import Alert from '@/components/ui/Alert.vue';
import UsersTable from '@/modules/users/UsersTable.vue';
import { useRoute } from 'vue-router';
import { computed } from 'vue';

const route = useRoute();

const { users, isLoading, isError } = useGetTeamMembersDetails(
	computed(() => Number(route?.params?.teamId)),
);
</script>

<template>
	<Container>
		<template v-if="isLoading">
			<SpinnerLoader />
		</template>
		<template v-else-if="isError || !users?.data || users.data.length <= 0">
			<Alert variant="destructive">Something went wrong on the server</Alert>
		</template>
		<template v-else>
			<UsersTable :users="users.data" />
		</template>
	</Container>
</template>
