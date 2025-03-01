<script setup>
import { useForm } from '@inertiajs/vue3'
import { watch } from 'vue'

const props = defineProps({
    user: Object,
})

const emit = defineEmits(['close'])

const form = useForm({
    name: '',
    email: '',
})

watch(
    () => props.user,
    (user) => {
        if (user) {
            form.name = user.name
            form.email = user.email
        }
    },
)

function closeModal() {
    emit('close')
}

function updateUser() {
    form.put(route('users.update', props.user.id), {
        onSuccess: closeModal,
    })
}
</script>

<template>
    <Modal
        :show="user"
        title="Editing User"
        size="md"
        @close="closeModal"
    >
        <form
            class="space-y-6"
            @submit.prevent="updateUser"
        >
            <div>
                <InputLabel for="name"> Name </InputLabel>
                <TextInput
                    v-model="form.name"
                    name="name"
                    class="mt-1 w-full"
                />
                <InputError
                    :message="form.errors.name"
                    class="mt-2"
                />
            </div>

            <div>
                <InputLabel for="email"> Email </InputLabel>
                <TextInput
                    v-model="form.email"
                    name="email"
                    class="mt-1 w-full"
                />
                <InputError
                    :message="form.errors.email"
                    class="mt-2"
                />
            </div>

            <div class="flex justify-end space-x-3">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
                <PrimaryButton type="submit"> Update </PrimaryButton>
            </div>
        </form>
    </Modal>
</template>
