<script setup>
import { Link, Head, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import Modal from './Modal.vue'

defineProps({
    users: Array,
})

const editingUser = ref(false)

function openEditModal(user) {
    editingUser.value = user

    form.name = user.name
    form.email = user.email
}

const form = useForm({
    name: '',
    email: '',
})

function closeModal() {
    editingUser.value = false
}

function updateUser() {
    form.put(route('users.update', editingUser.value.id), {
        onSuccess: closeModal,
    })
}
</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout title="Users">
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                            >
                                User
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                            >
                                Email
                            </th>
                            <th
                                scope="col"
                                class="relative px-6 py-3"
                            >
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <tr
                            v-for="user in users"
                            :key="user.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center">
                                    <div class="size-10 shrink-0">
                                        <img
                                            :src="`https://i.pravatar.cc/150?u=${user.id}`"
                                            :alt="user.name"
                                            class="size-10 rounded-full border border-gray-200 object-cover"
                                        />
                                    </div>
                                    <div class="ml-4">
                                        <div
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{ user.name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="text-sm text-gray-500">
                                    {{ user.email }}
                                </div>
                            </td>
                            <td
                                class="space-x-3 whitespace-nowrap px-6 py-4 text-right text-sm font-medium"
                            >
                                <Link
                                    :href="route('users.show', user)"
                                    class="text-indigo-600 hover:text-indigo-900"
                                >
                                    View
                                </Link>
                                <Link
                                    :href="route('users.edit', user)"
                                    class="text-indigo-600 hover:text-indigo-900"
                                >
                                    Edit
                                </Link>
                                <button
                                    class="text-indigo-600 hover:text-indigo-900"
                                    @click="openEditModal(user)"
                                >
                                    Edit in Modal
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>

    <Modal
        :show="editingUser !== false"
        title="Editing User"
        size="md"
        close-manually
        @close="closeModal"
    >
        <template #title>
            <h3 class="font-bold text-red-500">Edit User!</h3>
        </template>
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
