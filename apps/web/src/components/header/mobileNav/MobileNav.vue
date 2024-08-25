<script setup lang="ts">
import Nav from '@/components/ui/navigation/Nav.vue';
import Navbar from '@/components/ui/navigation/Navbar.vue';
import NavItem from '@/components/ui/navigation/NavItem.vue';
import NavItemLink from '@/components/ui/navigation/NavItemLink.vue';
import { links } from '@/components/header/utils';
import DialogTrigger from '@/components/dialog/DialogTrigger.vue';
</script>

<template>
	<Nav orientation="vertical" class="w-full flex-auto max-w-none">
		<Navbar class="flex-col gap-y-1.5">
			<template v-for="{ label, to } in links" :key="label">
				<NavItem>
					<DialogTrigger>
						<NavItemLink :to="to">
							<span class="text-base">{{ label }}</span>
						</NavItemLink>
					</DialogTrigger>
				</NavItem>
			</template>

			<NavItem>
				<DialogTrigger>
					<NavItemLink to="/login">
						<span class="text-base">Login</span>
					</NavItemLink>
				</DialogTrigger>
			</NavItem>
		</Navbar>
	</Nav>
</template>
