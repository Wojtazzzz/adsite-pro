<script setup lang="ts">
import Button from '@/components/ui/Button.vue';
import Field from '@/components/ui/form/Field.vue';
import Form from '@/components/ui/form/Form.vue';
import Popover from '@/components/ui/popover/Popover.vue';
import PopoverTrigger from '@/components/ui/popover/PopoverTrigger.vue';
import PopoverContent from '@/components/ui/popover/PopoverContent.vue';
import { useCreateTeam } from '@/modules/teams/createTeam/useCreateTeam';
import { type CreateTeamFormData, createTeamFormSchema } from '@/modules/teams/createTeam/utils';
import { useBoolean } from '@/composables/useBoolean';

const { state: isOpen, setTrue: open, setFalse: close } = useBoolean();

const { createTeam } = useCreateTeam();

const onSubmit = (values: CreateTeamFormData) => {
	createTeam(values, close);
};
</script>

<template>
	<Popover :open="isOpen">
		<PopoverTrigger>
			<Button type="button" @click="open">Create team</Button>
		</PopoverTrigger>
		<PopoverContent
			@interactOutside="close"
			@pointerDownOutside="close"
			@escapeKeyDown="close"
			@focusOutside="close"
		>
			<Form :schema="createTeamFormSchema" :on-submit="onSubmit">
				<div class="space-y-6">
					<Field type="text" name="name" placeholder="My Super Team" label="Name" />

					<div class="flex justify-end">
						<Button type="submit">Create</Button>
					</div>
				</div>
			</Form>
		</PopoverContent>
	</Popover>
</template>
