<script setup lang="ts">
import Button from '@/components/ui/Button.vue';
import Field from '@/components/ui/form/Field.vue';
import Form from '@/components/ui/form/Form.vue';
import Popover from '@/components/ui/popover/Popover.vue';
import PopoverTrigger from '@/components/ui/popover/PopoverTrigger.vue';
import { PopoverContent } from '@/components/ui-library/popover';
import { useCreateTeam } from '@/modules/tasks/createTeam/useCreateTeam';
import { type CreateTeamFormData, createTeamFormSchema } from '@/modules/tasks/createTeam/utils';

const { createTeam } = useCreateTeam();
const onSubmit = (values: CreateTeamFormData) => {
	createTeam(values);
};
</script>

<template>
	<Popover>
		<PopoverTrigger>
			<Button type="button">Create team</Button>
		</PopoverTrigger>
		<PopoverContent>
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
