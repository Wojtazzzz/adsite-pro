<script setup lang="ts">
import Logo from '@/components/ui/Logo.vue';
import DesktopNav from '@/components/header/DesktopNav.vue';
import MobileNavDialog from '@/components/header/mobileNav/MobileNavDialog.vue';
import Container from '@/components/ui/Container.vue';
import ToggleTheme from '@/components/ui/ToggleTheme.vue';
import Invitations from '@/components/header/invitations/Invitations.vue';
import { useMe } from '@/composables/useMe';

const { isUserLogged } = useMe();
</script>

<template>
	<div class="border-b fixed top-0 left-0 z-30 bg-background w-full">
		<Container>
			<header class="relative flex items-center justify-between">
				<RouterLink to="/" aria-label="Home page" class="inline-flex items-center">
					<Logo />

					<span
						class="ml-2.5 text-xl font-bold tracking-wide text-primary-background uppercase"
					>
						Teamer
					</span>
				</RouterLink>

				<div class="flex gap-x-3 md:gap-x-4">
					<div class="hidden md:block">
						<DesktopNav />
					</div>

					<div class="flex gap-x-1.5">
						<template v-if="isUserLogged">
							<Invitations />
						</template>

						<ToggleTheme />

						<div class="md:hidden">
							<MobileNavDialog />
						</div>
					</div>
				</div>
			</header>
		</Container>
	</div>
</template>
