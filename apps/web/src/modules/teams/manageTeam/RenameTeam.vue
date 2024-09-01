<script setup lang="ts">
import DialogContent from '@/components/ui/card/dialog/DialogContent.vue';
import DialogDescription from '@/components/ui/card/dialog/DialogDescription.vue';
import DialogHeader from '@/components/ui/card/dialog/DialogHeader.vue';
import DialogTitle from '@/components/ui/card/dialog/DialogTitle.vue';
import Dialog from '@/components/ui/card/dialog/Dialog.vue';
import DialogTrigger from '@/components/ui/card/dialog/DialogTrigger.vue';
import IconPencil from '@/components/icons/IconPencil.vue';
import Button from '@/components/ui/Button.vue';
import type { Team } from '@/modules/teams/useGetUserTeams';
import Form from '@/components/ui/form/Form.vue';
import Field from '@/components/ui/form/Field.vue';
import { type RenameTeamFormValues, renameTeamSchema } from '@/modules/teams/manageTeam/utils';
import { useRenameTeam } from '@/modules/teams/manageTeam/useRenameTeam';
import { useBoolean } from '@/composables/useBoolean';

const props = defineProps<{
	team: Team;
}>();

const { state: isOpen, setTrue: open, setFalse: close } = useBoolean();

const { renameTeam } = useRenameTeam();

const onSubmit = (values: RenameTeamFormValues) => {
	renameTeam(
		{
			teamId: props.team.id,
			newName: values.name,
		},
		close,
	);
};
</script>

<template>
	<Dialog :open="isOpen">
		<DialogTrigger>
			<Button type="button" @click="open">
				<span class="sr-only">Rename team</span>
				<IconPencil />
			</Button>
		</DialogTrigger>
		<DialogContent
			vertical-position="center"
			@closeClick="close"
			@escapeKeyDown="close"
			@focusOutside="close"
			@interactOutside="close"
			@pointerDownOutside="close"
		>
			<DialogHeader>
				<DialogTitle>
					<span>Rename Team</span>
				</DialogTitle>
				<DialogDescription>
					<div class="mt-6">
						<Form :schema="renameTeamSchema" :on-submit="onSubmit">
							<div class="space-y-6">
								<Field
									type="text"
									name="name"
									label="Team name"
									:value="team.name"
									placeholder="My super team"
								/>

								<div class="flex justify-end">
									<Button type="submit">Rename</Button>
								</div>
							</div>
						</Form>
					</div>
				</DialogDescription>
			</DialogHeader>
		</DialogContent>
	</Dialog>
</template>
