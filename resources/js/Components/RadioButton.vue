<script setup lang="ts">
import { computed } from 'vue';

const emit = defineEmits(['update:checked']);

const props = withDefaults(defineProps<{
    checked: boolean;
    name: string;
    value: any;
    title: string;
}>(),
    {
        checked:false,
    }
);
const proxyActive = computed({
    get() {
        return props.value;
    },

    set(val) {
        emit('update:active', props.value);
    },
});
</script>

<template>
    <div class="mb-[0.125rem] min-h-[1.5rem] pl-[1.5rem] flex items-center">
        <input
            class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
            v-model="proxyActive"
            :checked="checked"
            type="radio"
            :name="name"
            @change="emit('update:change',)"
            :id="name+'.'+value" />
        <label
            class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer text-gray-400"
            :for="name+'.'+value">
            {{title}}
        </label>
    </div>
</template>
