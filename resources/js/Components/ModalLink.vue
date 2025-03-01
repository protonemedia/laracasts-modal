<script setup>
import { open } from '@/useModal.js'

defineProps({
    href: {
        type: String,
        required: true,
    },
})
</script>

<template>
    <button
        type="button"
        @click="open(href)"
    >
        <slot />
    </button>
</template>
