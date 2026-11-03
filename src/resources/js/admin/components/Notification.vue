<template lang="">
    <div :class="['notification', 'notification--primary', `notification--${type}`, { 'notification--active': isActive }]" id="notification">
        <div class="notification__inner">
            <span class="notification__heading">
                {{ heading }}
            </span>
            <span class="notification__text">
                {{ text }}
            </span>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted } from 'vue';
const props = defineProps({
    heading: {
        type: String,
        required: true,
    },
    text: {
        type: String,
        default: ''
    },
    type: {
        type: String,
        default: 'info',
        validator: (value) => ['success', 'error', 'warning', 'info'].includes(value),
    }
})
const isActive = ref(false)
onMounted(() => {
    setTimeout(() => {
        isActive.value = true
    }, 10)
    setTimeout(() => {
        isActive.value = false
    }, 5000)
})
</script>
<style lang="">

</style>