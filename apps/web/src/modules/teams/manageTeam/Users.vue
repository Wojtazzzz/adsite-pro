<script setup lang="ts">
import ButtonLink from '@/components/ui/ButtonLink.vue';
import IconUser from '@/components/icons/IconUser.vue';
</script>

<template>
	<ButtonLink to="/users">
		<span class="sr-only">Manage users</span>
		<IconUser />
	</ButtonLink>
</template>
