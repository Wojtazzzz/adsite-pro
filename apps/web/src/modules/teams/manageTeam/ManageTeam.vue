<script setup lang="ts">
import type { Team } from '@/modules/teams/useGetUserTeams';
import Delete from '@/modules/teams/manageTeam/Delete.vue';
import Rename from '@/modules/teams/manageTeam/Rename.vue';

defineProps<{
	currentTeam: Team;
}>();
</script>

<template>
	<Rename :team="currentTeam" />
	<Delete :team-id="currentTeam.id" />
</template>
