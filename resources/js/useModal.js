import { router } from '@inertiajs/vue3'
import axios from 'axios'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ref } from 'vue'

const modal = ref(null)

function setModal(data) {
    resolvePageComponent(
        `./Pages/${data.component}.vue`,
        import.meta.glob('./Pages/**/*.vue'),
    ).then((component) => {
        modal.value = data
        modal.value.resolvedComponent = component
        modal.value.show = true
    })
}

function open(href) {
    axios
        .get(href, {
            headers: {
                'X-Inertia': true,
                'X-Modal': true,
            },
        })
        .then((response) => setModal(response.data))
}

function close() {
    if (modal.value) {
        modal.value.show = false
    }
}

function reset() {
    // redirect back to base url
    if (modal.value?.baseUrl && modal.value.baseUrl !== window.location.href) {
        router.visit(modal.value.baseUrl)
    }

    modal.value = null
}

export { close, modal, open, reset, setModal }
