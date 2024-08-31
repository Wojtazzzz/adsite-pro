<script setup lang="ts">
import ButtonLink from '@/components/ui/ButtonLink.vue';
import IconUser from '@/components/icons/IconUser.vue';

defineProps<{ teamId: number }>();
</script>

<template>
	<ButtonLink :to="`/users/${teamId}`">
		<span class="sr-only">Manage users</span>
		<IconUser />
	</ButtonLink>
</template>
