
<template>
    <div class="select" :class="{ 'select--active': isOpen }">
        <div class="select__head" @click="toggleSelect">
            <span class="select__selected">
                {{ selected?.translated_name }}
            </span>

            <input
                class="select__input"
                type="hidden"
                :value="selected?.value ?? ''"
                :name="name"
            />

            <svg viewBox="0 -960 960 960" class="icon icon--m icon--primary">
                <path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z" />
            </svg>
        </div>

        <div class="select__body">
            <span
                v-for="option in options"
                :key="option.value"
                class="select__option"
                :data-value="option.value"
                @click="selectOption(option, $event)"
            >
                {{ option.translated_name }}
            </span>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    options: {
        type: Array,
        required: true,
    },
    name: {
        type: String,
        required: true,
    },
});

const isOpen = ref(false);
const selectedOption = ref(null);

const selected = computed(() => {
    if (selectedOption.value) {
        return selectedOption.value;
    }

    const params = new URLSearchParams(window.location.search);
    const currentSort = params.get(props.name);

    return props.options.find(
        option => option.value === currentSort
    ) ?? props.options.find(
        option => option.is_default === true
    ) ?? null;
});

function toggleSelect() {
    isOpen.value = !isOpen.value;
}

function selectOption(option, event) {
    selectedOption.value = option;
    isOpen.value = false;

    const select = event.currentTarget.closest('.select');
    const callbackName = select.dataset.callback;

    if (
        callbackName &&
        typeof window[callbackName] === 'function'
    ) {
        window[callbackName](event.currentTarget);
    }
}

console.log('Options:', props.options);
console.log('Default:', props.options.find(option => option.is_default));
</script>
