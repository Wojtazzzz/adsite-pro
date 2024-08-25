<script setup lang="ts">
import { CaretSortIcon, CheckIcon } from '@radix-icons/vue';
import { cn } from '@/utils/functions';
import { Button } from '@/components/ui-library/button';
import {
	Command,
	CommandEmpty,
	CommandGroup,
	CommandInput,
	CommandItem,
	CommandList,
} from '@/components/ui-library/command';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui-library/popover';
import { useBoolean } from '@/composables/useBoolean';

export type ComboboxOption = {
	value: string | number;
	label: string;
};

type SelectEvent = CustomEvent<{
	originalEvent: PointerEvent;
	value?: string | number | boolean | Record<string, any>;
}>;

defineProps<{
	options: ComboboxOption[];
	placeholder: string;
	notFoundMessage: string;
}>();

const { state: isOpen, setFalse: close } = useBoolean();

const currentValue = defineModel<ComboboxOption['value'] | null>({
	default: null,
});

const onSelect = (ev: SelectEvent) => {
	if (typeof ev.detail.value === 'string' || typeof ev.detail.value === 'number') {
		currentValue.value = ev.detail.value;
	}

	close();
};
</script>

<template>
	<Popover v-model:open="isOpen">
		<PopoverTrigger as-child>
			<Button
				variant="outline"
				role="combobox"
				:aria-expanded="isOpen"
				class="w-[200px] justify-between"
			>
				{{
					currentValue
						? options.find((option) => option.value === currentValue)?.label
						: placeholder
				}}
				<CaretSortIcon class="ml-2 h-4 w-4 shrink-0 opacity-50" />
			</Button>
		</PopoverTrigger>
		<PopoverContent class="w-[200px] p-0">
			<Command>
				<CommandInput class="h-9" :placeholder="placeholder" />
				<CommandEmpty>{{ notFoundMessage }}</CommandEmpty>
				<CommandList>
					<CommandGroup>
						<CommandItem
							v-for="{ value, label } in options"
							:key="value"
							:value="value"
							@select="onSelect"
						>
							{{ label }}
							<CheckIcon
								:class="
									cn(
										'ml-auto h-4 w-4',
										currentValue === value ? 'opacity-100' : 'opacity-0',
									)
								"
							/>
						</CommandItem>
					</CommandGroup>
				</CommandList>
			</Command>
		</PopoverContent>
	</Popover>
</template>
