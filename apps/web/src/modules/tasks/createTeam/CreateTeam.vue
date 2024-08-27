<script setup lang="ts">
import Button from '@/components/ui/Button.vue';
import Sheet from '@/components/ui/sheet/Sheet.vue';
import SheetTrigger from '@/components/ui/sheet/SheetTrigger.vue';
import { SheetContent } from '@/components/ui-library/sheet';
import SheetHeader from '@/components/ui/sheet/SheetHeader.vue';
import SheetTitle from '@/components/ui/sheet/SheetTitle.vue';
import SheetDescription from '@/components/ui/sheet/SheetDescription.vue';
</script>

<template>
	<Sheet>
		<SheetTrigger>
			<Button type="button">Create team</Button>
		</SheetTrigger>
		<SheetContent>
			<SheetHeader>
				<SheetTitle>Are you absolutely sure?</SheetTitle>
				<SheetDescription>
					This action cannot be undone. This will permanently delete your account and
					remove your data from our servers.
				</SheetDescription>
			</SheetHeader>
		</SheetContent>
	</Sheet>
</template>
