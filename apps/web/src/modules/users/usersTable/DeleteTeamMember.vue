<script setup lang="ts">
import Button from '@/components/ui/Button.vue';
import IconTrash from '@/components/icons/IconTrash.vue';
import AlertDialog from '@/components/ui/alertDialog/AlertDialog.vue';
import AlertDialogTrigger from '@/components/ui/alertDialog/AlertDialogTrigger.vue';
import AlertDialogContent from '@/components/ui/alertDialog/AlertDialogContent.vue';
import AlertDialogHeader from '@/components/ui/alertDialog/AlertDialogHeader.vue';
import AlertDialogTitle from '@/components/ui/alertDialog/AlertDialogTitle.vue';
import AlertDialogFooter from '@/components/ui/alertDialog/AlertDialogFooter.vue';
import AlertDialogCancel from '@/components/ui/alertDialog/AlertDialogCancel.vue';
import AlertDialogAction from '@/components/ui/alertDialog/AlertDialogAction.vue';
import AlertDialogDescription from '@/components/ui/alertDialog/AlertDialogDescription.vue';
import { useDeleteTeamMember } from '@/modules/users/usersTable/useDeleteTeamMember';

defineProps<{
	teamId: number;
	userId: number;
}>();

const { deleteTeamMember } = useDeleteTeamMember();
</script>

<template>
	<AlertDialog>
		<AlertDialogTrigger>
			<Button type="button">
				<span class="sr-only">Remove team member</span>
				<IconTrash />
			</Button>
		</AlertDialogTrigger>
		<AlertDialogContent>
			<AlertDialogHeader>
				<AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
				<AlertDialogDescription>This action cannot be undone.</AlertDialogDescription>
			</AlertDialogHeader>
			<AlertDialogFooter>
				<AlertDialogCancel>
					<Button variant="secondary" type="button">Cancel</Button>
				</AlertDialogCancel>
				<AlertDialogAction>
					<Button type="button" @click="deleteTeamMember({ teamId, userId })">
						Delete
					</Button>
				</AlertDialogAction>
			</AlertDialogFooter>
		</AlertDialogContent>
	</AlertDialog>
</template>
