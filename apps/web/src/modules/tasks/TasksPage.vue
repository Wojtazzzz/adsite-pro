<script setup lang="ts">
import Container from '@/components/ui/Container.vue';
import { useGetTasks } from '@/modules/tasks/useGetTasks';

const { data } = useGetTasks();
</script>

<template>
	<Container> </Container>
</template>
