<script setup>
import { watch } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { modal, close, reset, setModal } from '@/useModal.js'
import axios from 'axios'

const page = usePage()

function addBaseUrlToRequest(config) {
    if (page.props._modal) {
        config.headers['X-Modal-Base-Url'] = page.props._modal.baseUrl
    }

    return config
}

watch(
    () => page.props._modal,
    (modal) => {
        if (modal) {
            axios.interceptors.request.use(addBaseUrlToRequest)
            setModal({ ...modal })
        } else {
            axios.interceptors.request.eject(addBaseUrlToRequest)
            close()
        }
    },
    { immediate: true },
)
</script>

<template>
    <modal.resolvedComponent.default
        v-if="modal"
        :show="modal.show"
        v-bind="modal.props"
        @close="close"
        @after-leave="reset"
    />
</template>
