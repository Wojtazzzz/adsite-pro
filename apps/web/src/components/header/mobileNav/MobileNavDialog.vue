<script setup lang="ts">
import DialogContent from '@/components/ui/card/dialog/DialogContent.vue';
import DialogDescription from '@/components/ui/card/dialog/DialogDescription.vue';
import DialogHeader from '@/components/ui/card/dialog/DialogHeader.vue';
import Logo from '@/components/ui/Logo.vue';
import DialogTitle from '@/components/ui/card/dialog/DialogTitle.vue';
import Dialog from '@/components/ui/card/dialog/Dialog.vue';
import DialogTrigger from '@/components/ui/card/dialog/DialogTrigger.vue';
import IconBars from '@/components/icons/IconBars.vue';
import MobileNav from '@/components/header/mobileNav/MobileNav.vue';
import Button from '@/components/ui/Button.vue';
</script>

<template>
	<Dialog>
		<DialogTrigger>
			<Button class="p-2 -mr-1 rounded" type="button">
				<span class="sr-only">Open menu</span>
				<IconBars />
			</Button>
		</DialogTrigger>
		<DialogContent vertical-position="top">
			<DialogTrigger>
				<RouterLink to="/" aria-label="Home page" class="inline-flex items-center w-fit">
					<Logo />

					<span class="ml-2.5 text-xl font-bold tracking-wide text-foreground uppercase">
						Teamer
					</span>
				</RouterLink>
			</DialogTrigger>
			<DialogHeader>
				<DialogTitle>
					<span class="sr-only">Navigation</span>
				</DialogTitle>
				<DialogDescription>
					<MobileNav />
				</DialogDescription>
			</DialogHeader>
		</DialogContent>
	</Dialog>
</template>
