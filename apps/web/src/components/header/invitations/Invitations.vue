<script setup lang="ts">
import DialogContent from '@/components/ui/card/dialog/DialogContent.vue';
import DialogDescription from '@/components/ui/card/dialog/DialogDescription.vue';
import DialogHeader from '@/components/ui/card/dialog/DialogHeader.vue';
import DialogTitle from '@/components/ui/card/dialog/DialogTitle.vue';
import Dialog from '@/components/ui/card/dialog/Dialog.vue';
import DialogTrigger from '@/components/ui/card/dialog/DialogTrigger.vue';
import IconBell from '@/components/icons/IconBell.vue';
import Button from '@/components/ui/Button.vue';
import { useGetInvitations } from '@/components/header/invitations/useGetInvitations';
import Alert from '@/components/ui/Alert.vue';
import SpinnerLoader from '@/components/ui/SpinnerLoader.vue';
import IconCheck from '@/components/icons/IconCheck.vue';
import IconCross from '@/components/icons/IconCross.vue';
import { useRespondToInvitation } from '@/components/header/invitations/useRespondToInvitation';

const { invitations, isLoading, isError } = useGetInvitations();
const { accept, reject } = useRespondToInvitation();
</script>

<template>
	<Dialog>
		<DialogTrigger>
			<Button type="button" variant="outline">
				<span class="sr-only">Your invitations</span>
				<IconBell />
			</Button>
		</DialogTrigger>
		<DialogContent vertical-position="center">
			<DialogHeader>
				<DialogTitle>
					<span>Invitations</span>
				</DialogTitle>
				<DialogDescription>
					<div class="mt-6">
						<template v-if="isLoading">
							<SpinnerLoader />
						</template>

						<template v-else-if="isError || !invitations?.data">
							<Alert variant="destructive">Something went wrong on the server</Alert>
						</template>

						<template v-else-if="invitations.data.length <= 0">
							<div>You have no new invitations.</div>
						</template>
						<template v-else>
							<ul class="w-full">
								<template
									v-for="invitation in invitations.data"
									:key="invitation.id"
								>
									<li class="flex justify-between">
										<div>
											<h3>{{ invitation.team_name }}</h3>
										</div>
										<div class="flex gap-x-3">
											<Button type="button" @click="accept(invitation.id)">
												<span class="sr-only">Accept</span>
												<IconCheck />
											</Button>
											<Button
												type="button"
												variant="destructive"
												@click="reject(invitation.id)"
											>
												<span class="sr-only">Reject</span>
												<IconCross />
											</Button>
										</div>
									</li>
								</template>
							</ul>
						</template>
					</div>
				</DialogDescription>
			</DialogHeader>
		</DialogContent>
	</Dialog>
</template>
