<script setup lang="ts">
import DropdownMenu from '@/components/ui/dropdownMenu/DropdownMenu.vue';
import DropdownMenuTrigger from '@/components/ui/dropdownMenu/DropdownMenuTrigger.vue';
import DropdownMenuContent from '@/components/ui/dropdownMenu/DropdownMenuContent.vue';
import DropdownMenuLabel from '@/components/ui/dropdownMenu/DropdownMenuLabel.vue';
import DropdownMenuSeparator from '@/components/ui/dropdownMenu/DropdownMenuSeparator.vue';
import DropdownMenuItem from '@/components/ui/dropdownMenu/DropdownMenuItem.vue';
import Button from '@/components/ui/Button.vue';
import IconMenu from '@/components/icons/IconMenu.vue';
import type { Team } from '@/modules/tasks/useGetUserTeams';

defineProps<{
	currentTeam: Team;
}>();
</script>

<template>
	<DropdownMenu>
		<DropdownMenuTrigger>
			<Button type="button">
				<span class="sr-only">Team settings</span>
				<IconMenu />
			</Button>
		</DropdownMenuTrigger>
		<DropdownMenuContent>
			<DropdownMenuLabel>My Team ({{ currentTeam.name }})</DropdownMenuLabel>
			<DropdownMenuSeparator />
			<DropdownMenuItem>Manage users</DropdownMenuItem>
			<DropdownMenuItem>Rename</DropdownMenuItem>
			<DropdownMenuItem>Delete</DropdownMenuItem>
		</DropdownMenuContent>
	</DropdownMenu>
</template>
