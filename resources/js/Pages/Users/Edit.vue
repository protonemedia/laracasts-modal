<script setup>
import { Head, useForm } from '@inertiajs/vue3'

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
})

const form = useForm({
    name: props.user.name,
    email: props.user.email,
})

function updateUser() {
    form.put(route('users.update', props.user.id))
}
</script>

<template>
    <Head :title="`Edit ${user.name}`" />

    <AuthenticatedLayout :title="`Edit ${user.name}`">
        <Panel>
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
                    <SecondaryButton
                        @click="$inertia.visit(route('users.index'))"
                    >
                        Cancel
                    </SecondaryButton>
                    <PrimaryButton type="submit"> Update </PrimaryButton>
                </div>
            </form>
        </Panel>
    </AuthenticatedLayout>
</template>
