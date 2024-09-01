<script setup lang="ts">
import Button from '@/components/ui/Button.vue';
import Field from '@/components/ui/form/Field.vue';
import Form from '@/components/ui/form/Form.vue';
import { inviteUserFormSchema, type InviteUserFormData } from '@/modules/users/inviteUser/utils';
import { useInviteUser } from '@/modules/users/inviteUser/useInviteUser';
import IconSearch from '@/components/icons/IconSearch.vue';

const { invite } = useInviteUser();

const onSubmit = (values: InviteUserFormData) => {
	invite(values);
};
</script>

<template>
	<Form :schema="inviteUserFormSchema" :on-submit="onSubmit">
		<div class="flex items-center gap-x-4">
			<Field
				type="email"
				name="email"
				label="E-mail"
				placeholder="john.smith@gmail.com"
				:visible-validate-errors="false"
			/>

			<div class="mt-8 h-9">
				<Button type="submit">
					<span class="sr-only">Invite</span>
					<IconSearch />
				</Button>
			</div>
		</div>
	</Form>
</template>
