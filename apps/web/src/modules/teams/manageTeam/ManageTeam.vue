<script setup lang="ts">
import type { Team } from '@/modules/teams/useGetUserTeams';
import DeleteTeam from '@/modules/teams/manageTeam/DeleteTeam.vue';
import RenameTeam from '@/modules/teams/manageTeam/RenameTeam.vue';
import Users from '@/modules/teams/manageTeam/Users.vue';

defineProps<{
	currentTeam: Team;
}>();
</script>

<template>
	<Users :team-id="currentTeam.id" />
	<RenameTeam :team="currentTeam" />
	<DeleteTeam :team-id="currentTeam.id" />
</template>
