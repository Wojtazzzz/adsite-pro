<script setup lang="ts">
import type { Team } from '@/modules/tasks/useGetUserTeams';
import Delete from '@/modules/tasks/manageTeam/Delete.vue';
import Rename from '@/modules/tasks/manageTeam/Rename.vue';

defineProps<{
	currentTeam: Team;
}>();
</script>

<template>
	<Rename :team="currentTeam" />
	<Delete :team-id="currentTeam.id" />
</template>
