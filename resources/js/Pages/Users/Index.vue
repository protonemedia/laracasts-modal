<script setup>
import { Link, Head } from '@inertiajs/vue3'
import { ref } from 'vue'
import EditModal from './EditModal.vue'

defineProps({
    users: Array,
})

const editingUser = ref(null)
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
                                    @click="editingUser = user"
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

    <EditModal
        :user="editingUser"
        @close="editingUser = false"
    />
</template>
