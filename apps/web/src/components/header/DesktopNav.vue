<script setup lang="ts">
import Nav from '@/components/ui/navigation/Nav.vue';
import ButtonLink from '@/components/ui/ButtonLink.vue';
import Navbar from '@/components/ui/navigation/Navbar.vue';
import NavItem from '@/components/ui/navigation/NavItem.vue';
import NavItemLink from '@/components/ui/navigation/NavItemLink.vue';
import { links } from '@/components/header/utils';
import { useMe } from '@/composables/useMe';

const { isUserLogged } = useMe();
</script>

<template>
	<Nav>
		<Navbar>
			<template v-for="{ label, to } in links" :key="label">
				<NavItem>
					<NavItemLink :to="to">
						{{ label }}
					</NavItemLink>
				</NavItem>
			</template>

			<template v-if="isUserLogged">
				<NavItem>
					<ButtonLink to="/tasks">My tasks</ButtonLink>
				</NavItem>
			</template>
			<template v-else>
				<NavItem>
					<ButtonLink to="/login">Login</ButtonLink>
				</NavItem>
			</template>
		</Navbar>
	</Nav>
</template>
