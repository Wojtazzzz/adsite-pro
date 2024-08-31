<script setup lang="ts">
import type { Team } from '@/modules/teams/useGetUserTeams';
import Delete from '@/modules/teams/manageTeam/Delete.vue';
import Rename from '@/modules/teams/manageTeam/Rename.vue';
import Users from '@/modules/teams/manageTeam/Users.vue';

defineProps<{
	currentTeam: Team;
}>();
</script>

<template>
	<Users :team-id="currentTeam.id" />
	<Rename :team="currentTeam" />
	<Delete :team-id="currentTeam.id" />
</template>
