<template lang="">
    <div class="select">
        <div class="select__head" @click="toggleSelect">
            <span class="select__selected">
                {{ current.translated_name }}
            </span>
            <input class="select__input" type="text" :value="`${current.id}`" :name="`${name}`" hidden/>
            <svg viewBox="0 -960 960 960" class="icon icon--m icon--primary">
                <path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z" />
            </svg>
        </div>
        <div class="select__body">
            <span 
                v-for="option in options" 
                class="select__option"
                :data-value="`${option.sort}`"
                @click="selectOption"
            >
                {{ option.translated_name }}
            </span>
        </div>
    </div>
</template>
<script setup>
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
    }
});

function toggleSelect(event) {
    const SELECT = event.target.closest('.select');
    SELECT.classList.toggle('select--active');
}
function selectOption(event) {
    const OPTION = event.target;
    const SELECT = OPTION.closest('.select');
    const SELECTED = SELECT.querySelector('.select__selected');
    const INPUT = SELECT.querySelector('.select__input');

    SELECTED.textContent = OPTION.textContent;
    INPUT.setAttribute('value', OPTION.dataset.value);

    SELECT.classList.remove('select--active');

    const callbackName = SELECT.dataset.callback;
    if (callbackName && window[callbackName]) {
        window[callbackName](OPTION);
    }
}
</script>