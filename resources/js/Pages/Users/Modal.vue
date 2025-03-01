<script setup>
defineProps({
    show: {
        type: Boolean,
        default: false,
    },
})
</script>

<template>
    <teleport to="body">
        <transition leave-active-class="duration-300">
            <div
                v-show="show"
                class="fixed inset-0 flex size-full items-center justify-center"
            >
                <transition
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
                    />
                </transition>

                <transition
                    enter-from-class="opacity-0 scale-90"
                    enter-to-class="opacity-100 scale-100"
                    enter-active-class="transition duration-300"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-90"
                    leave-active-class="transition duration-300"
                >
                    <div
                        v-show="show"
                        class="z-50 w-full max-w-md rounded-lg bg-white p-4"
                    >
                        <slot />
                    </div>
                </transition>
            </div>
        </transition>
    </teleport>
</template>
