import axios from 'axios'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ref } from 'vue'

const modal = ref(null)

function open(href) {
    axios
        .get(href, {
            headers: {
                'X-Inertia': true,
                'X-Modal': true,
            },
        })
        .then((response) => {
            resolvePageComponent(
                `./Pages/${response.data.component}.vue`,
                import.meta.glob('./Pages/**/*.vue'),
            ).then((component) => {
                modal.value = response.data
                modal.value.resolvedComponent = component
                modal.value.show = true
            })
        })
}

function close() {
    modal.value.show = false
}

function reset() {
    modal.value = null
}

export { close, modal, open, reset }
