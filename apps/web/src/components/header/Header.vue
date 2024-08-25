<script setup lang="ts">
import Logo from '@/components/ui/Logo.vue';
import DesktopNav from '@/components/header/DesktopNav.vue';
import MobileNavDialog from '@/components/header/mobileNav/MobileNavDialog.vue';
</script>

<template>
	<div class="border-b fixed top-0 left-0 z-30 bg-white w-full">
		<header
			class="px-4 py-5 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8"
		>
			<div class="relative flex items-center justify-between">
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
			</div>
		</header>
	</div>
</template>
