<script setup lang="ts">
import Logo from '@/components/ui/Logo.vue';
import DesktopNav from '@/components/header/DesktopNav.vue';
import MobileNavDialog from '@/components/header/mobileNav/MobileNavDialog.vue';
import Container from '@/components/ui/Container.vue';
</script>

<template>
	<div class="border-b fixed top-0 left-0 z-30 bg-white w-full">
		<Container>
			<header class="relative flex items-center justify-between">
				<RouterLink to="/" aria-label="Home page" class="inline-flex items-center">
					<Logo />

					<span class="ml-2.5 text-xl font-bold tracking-wide text-gray-800 uppercase">
						Teamer
					</span>
				</RouterLink>

				<div class="hidden md:block">
					<DesktopNav />
				</div>

				<div class="md:hidden">
					<MobileNavDialog />
				</div>
			</header>
		</Container>
	</div>
</template>
