<script setup lang="ts">
import DialogContent from '@/components/dialog/DialogContent.vue';
import DialogDescription from '@/components/dialog/DialogDescription.vue';
import DialogHeader from '@/components/dialog/DialogHeader.vue';
import Logo from '@/components/ui/Logo.vue';
import DialogTitle from '@/components/dialog/DialogTitle.vue';
import Dialog from '@/components/dialog/Dialog.vue';
import DialogTrigger from '@/components/dialog/DialogTrigger.vue';
import IconBars from '@/components/icons/IconBars.vue';
import MobileNav from '@/components/header/mobileNav/MobileNav.vue';
</script>

<template>
	<Dialog>
		<DialogTrigger>
			<button aria-label="Open Menu" class="p-2 -mr-1 rounded">
				<IconBars />
			</button>
		</DialogTrigger>
		<DialogContent vertical-position="top">
			<RouterLink to="/" aria-label="Home page" class="inline-flex items-center">
				<Logo />

				<span class="ml-2.5 text-xl font-bold tracking-wide text-gray-800 uppercase">
					Teamer
				</span>
			</RouterLink>
			<DialogHeader>
				<DialogTitle>
					<span class="sr-only"> Navigation </span>
				</DialogTitle>
				<DialogDescription>
					<MobileNav />
				</DialogDescription>
			</DialogHeader>
		</DialogContent>
	</Dialog>
</template>
