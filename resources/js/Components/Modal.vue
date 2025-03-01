<script setup>
import { onMounted, onUnmounted, watch } from 'vue'

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    title: {
        type: String,
        required: false,
    },
    size: {
        type: String,
        required: true,
        default: 'md',
        validator(value) {
            return ['sm', 'md', 'lg', 'xl'].includes(value)
        },
    },
    closeManually: {
        type: Boolean,
        required: false,
        default: false,
    },
})

const emit = defineEmits(['close', 'after-leave'])

watch(
    () => props.show,
    (show) => {
        document.body.style.overflow = show ? 'hidden' : ''
    },
    { immediate: true },
)

function close() {
    emit('close')
}

function closeOnEscape($event) {
    if (!props.show) {
        return
    }

    if ($event.key !== 'Escape') {
        return
    }

    const focusedElementName = $event.target.nodeName

    if (['INPUT', 'SELECT'].includes(focusedElementName)) {
        return
    }

    close()
}

if (!props.closeManually) {
    onMounted(() => document.addEventListener('keydown', closeOnEscape))
    onUnmounted(() => document.removeEventListener('keydown', closeOnEscape))
}
</script>

<template>
    <teleport to="body">
        <transition
            leave-active-class="duration-300"
            @after-leave="$emit('after-leave')"
        >
            <div
                v-show="show"
                dusk="modal-wrapper"
                class="fixed inset-0 flex size-full items-center justify-center"
            >
                <transition
                    appear
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    enter-active-class="transition duration-300"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                    leave-active-class="transition duration-300"
                >
                    <div
                        v-show="show"
                        class="fixed inset-0 z-40 size-full bg-black/75"
                        @click="closeManually ? null : close()"
                    />
                </transition>

                <transition
                    appear
                    enter-from-class="opacity-0 scale-90"
                    enter-to-class="opacity-100 scale-100"
                    enter-active-class="transition duration-300"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-90"
                    leave-active-class="transition duration-300"
                >
                    <div
                        v-show="show"
                        dusk="modal-content"
                        class="z-50 max-h-[calc(100vh-2rem)] w-full overflow-auto rounded-lg bg-white p-4"
                        :class="{
                            'max-w-sm': size === 'sm',
                            'max-w-md': size === 'md',
                            'max-w-lg': size === 'lg',
                            'max-w-xl': size === 'xl',
                        }"
                    >
                        <slot name="title">
                            <h1 class="mb-6 text-lg">{{ title }}</h1>
                        </slot>
                        <slot />
                    </div>
                </transition>
            </div>
        </transition>
    </teleport>
</template>
