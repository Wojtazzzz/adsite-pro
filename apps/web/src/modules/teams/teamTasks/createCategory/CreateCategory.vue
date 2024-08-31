<script setup lang="ts">
import DialogContent from '@/components/ui/card/dialog/DialogContent.vue';
import DialogDescription from '@/components/ui/card/dialog/DialogDescription.vue';
import DialogHeader from '@/components/ui/card/dialog/DialogHeader.vue';
import DialogTitle from '@/components/ui/card/dialog/DialogTitle.vue';
import Dialog from '@/components/ui/card/dialog/Dialog.vue';
import DialogTrigger from '@/components/ui/card/dialog/DialogTrigger.vue';
import Button from '@/components/ui/Button.vue';
import type { Team } from '@/modules/teams/useGetUserTeams';
import Form from '@/components/ui/form/Form.vue';
import Field from '@/components/ui/form/Field.vue';
import { useRenameTeam } from '@/modules/teams/manageTeam/useRenameTeam';
import { useBoolean } from '@/composables/useBoolean';
import {
	createCategorySchema,
	type CreateCategoryFormValues,
} from '@/modules/teams/teamTasks/createCategory/utils';
import { useCreateCategory } from '@/modules/teams/teamTasks/createCategory/useCreateCategory';

const props = defineProps<{
	teamId: number;
}>();

const { state: isOpen, setTrue: open, setFalse: close } = useBoolean();

const { createCategory } = useCreateCategory();

const onSubmit = (values: CreateCategoryFormValues) => {
	createCategory(
		{
			teamId: props.teamId,
			categoryName: values.name,
		},
		close,
	);
};
</script>

<template>
	<Dialog :open="isOpen">
		<DialogTrigger>
			<slot :open="open" />
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
					<span>Create Category</span>
				</DialogTitle>
				<DialogDescription>
					<div class="mt-6">
						<Form :schema="createCategorySchema" :on-submit="onSubmit">
							<div class="space-y-6">
								<Field
									type="text"
									name="name"
									label="Category name"
									placeholder="Garden"
								/>

								<div class="flex justify-end">
									<Button type="submit">Create</Button>
								</div>
							</div>
						</Form>
					</div>
				</DialogDescription>
			</DialogHeader>
		</DialogContent>
	</Dialog>
</template>
