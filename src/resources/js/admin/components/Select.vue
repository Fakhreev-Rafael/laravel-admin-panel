<template>
    <div class="select" :class="{ 'select--active': isOpen }">
        <div class="select__head" @click="toggleSelect">
            <span class="select__selected">
                {{ selected.translated_name }}
            </span>

            <input
                class="select__input"
                type="hidden"
                :value="selected.value"
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
import { ref, watch } from 'vue';

const props = defineProps({
    options: {
        type: Array,
        required: true,
    },
    current: {
        type: Object,
        required: true,
    },
    name: {
        type: String,
        required: true,
    },
});

const isOpen = ref(false);
const selected = ref(props.current);

watch(
    () => props.current,
    (value) => {
        selected.value = value;
    }
);

function toggleSelect() {
    isOpen.value = !isOpen.value;
}

function selectOption(option, event) {
    selected.value = option;
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
</script>