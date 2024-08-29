<script setup lang="ts">
import type { Team } from '@/modules/tasks/useGetUserTeams';
import Delete from '@/modules/tasks/manageTeam/Delete.vue';

defineProps<{
	currentTeam: Team;
}>();
</script>

<template>
	<Delete :team-id="currentTeam.id" />
</template>
