<script setup lang="ts">
import DialogContent from '@/components/ui/card/dialog/DialogContent.vue';
import DialogDescription from '@/components/ui/card/dialog/DialogDescription.vue';
import DialogHeader from '@/components/ui/card/dialog/DialogHeader.vue';
import DialogTitle from '@/components/ui/card/dialog/DialogTitle.vue';
</script>

<template>
	<DialogContent vertical-position="center">
		<DialogHeader>
			<DialogTitle>
				<span>Rename</span>
			</DialogTitle>
			<DialogDescription></DialogDescription>
		</DialogHeader>
	</DialogContent>
</template>
