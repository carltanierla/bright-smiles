<script setup>
import { ref, computed } from 'vue';

// Dummy Data
const users = ref([
    {
        id: 1,
        name: 'Jane Cooper',
        email: 'jane.cooper@example.com',
        role: 'Admin',
        status: 'Active',
        image: 'https://i.pravatar.cc/150?u=1',
        date: 'Jan 12, 2026',
    },
    {
        id: 2,
        name: 'Cody Fisher',
        email: 'cody.fisher@example.com',
        role: 'Editor',
        status: 'Active',
        image: 'https://i.pravatar.cc/150?u=2',
        date: 'Feb 24, 2026',
    },
    {
        id: 3,
        name: 'Esther Howard',
        email: 'esther.howard@example.com',
        role: 'Viewer',
        status: 'Inactive',
        image: 'https://i.pravatar.cc/150?u=3',
        date: 'Mar 10, 2026',
    },
    {
        id: 4,
        name: 'Jenny Wilson',
        email: 'jenny.wilson@example.com',
        role: 'Editor',
        status: 'Active',
        image: 'https://i.pravatar.cc/150?u=4',
        date: 'Apr 02, 2026',
    },
    {
        id: 5,
        name: 'Kristin Watson',
        email: 'kristin.watson@example.com',
        role: 'Admin',
        status: 'Inactive',
        image: 'https://i.pravatar.cc/150?u=5',
        date: 'May 15, 2026',
    },
    {
        id: 6,
        name: 'Cameron Williamson',
        email: 'cameron.w@example.com',
        role: 'Viewer',
        status: 'Active',
        image: 'https://i.pravatar.cc/150?u=6',
        date: 'Jun 22, 2026',
    },
]);

const searchQuery = ref('');

// Computed property for search functionality
const filteredUsers = computed(() => {
    if (!searchQuery.value) return users.value;
    return users.value.filter(
        (user) =>
            user.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            user.email
                .toLowerCase()
                .includes(searchQuery.value.toLowerCase()) ||
            user.role.toLowerCase().includes(searchQuery.value.toLowerCase()),
    );
});
</script>

<template>
    <div class="flex h-screen bg-gray-50 font-sans text-gray-900">
        <!-- Sidebar -->
        <aside
            class="hidden w-64 border-r border-gray-200 bg-white md:flex md:flex-col"
        >
            <div
                class="flex h-16 items-center justify-center border-b border-gray-200"
            >
                <span class="text-xl font-bold tracking-tight text-indigo-600"
                    >BrightSmiles</span
                >
            </div>
            <nav class="flex-1 space-y-1 p-4">
                <a
                    href="#"
                    class="flex items-center gap-3 rounded-lg bg-indigo-50 px-4 py-3 text-sm font-medium text-indigo-700"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                        />
                    </svg>
                    Online Form
                </a>
                <a
                    href="#"
                    class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-900"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                        />
                    </svg>
                    Online Payment
                </a>
                <a
                    href="#"
                    class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-900"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                    </svg>
                    Settings
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex flex-1 flex-col overflow-hidden">
            <!-- Top Header -->
            <header
                class="flex h-16 items-center justify-between border-b border-gray-200 bg-white px-6"
            >
                <h2 class="text-lg font-semibold text-gray-800">
                    Online Form
                </h2>
                <div class="flex items-center gap-4">
                    <button
                        class="relative rounded-full p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500"
                    >
                        <span
                            class="absolute top-1.5 right-1.5 h-2 w-2 rounded-full bg-red-500"
                        ></span>
                        <svg
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                            />
                        </svg>
                    </button>
                    <img
                        src="https://i.pravatar.cc/150?img=11"
                        alt="Admin"
                        class="h-9 w-9 rounded-full border border-gray-200 object-cover ring-2 ring-white"
                    />
                </div>
            </header>

            <!-- Datatable Section -->
            <div class="flex-1 overflow-y-auto p-6">
                <div class="mx-auto max-w-7xl">
                    <!-- Controls -->
                    <div
                        class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                    >
                        <div class="relative w-full max-w-md">
                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                            >
                                <svg
                                    class="h-5 w-5 text-gray-400"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    />
                                </svg>
                            </div>
                            <input
                                v-model="searchQuery"
                                type="text"
                                placeholder="Search users by name, email, or role..."
                                class="block w-full rounded-lg border border-gray-300 bg-white py-2.5 pr-4 pl-10 text-sm shadow-sm transition-all outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                            />
                        </div>
<!--                        <button-->
<!--                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"-->
<!--                        >-->
<!--                            <svg-->
<!--                                class="h-4 w-4"-->
<!--                                fill="none"-->
<!--                                viewBox="0 0 24 24"-->
<!--                                stroke="currentColor"-->
<!--                                stroke-width="2"-->
<!--                            >-->
<!--                                <path-->
<!--                                    stroke-linecap="round"-->
<!--                                    stroke-linejoin="round"-->
<!--                                    d="M12 4v16m8-8H4"-->
<!--                                />-->
<!--                            </svg>-->
<!--                            Add Member-->
<!--                        </button>-->
                    </div>

                    <!-- Table Container -->
                    <div
                        class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm"
                    >
                        <div class="overflow-x-auto">
                            <table
                                class="w-full text-left text-sm whitespace-nowrap text-gray-600"
                            >
                                <thead
                                    class="border-b border-gray-200 bg-gray-50 text-xs font-semibold tracking-wider text-gray-500 uppercase"
                                >
                                    <tr>
                                        <th scope="col" class="px-6 py-4">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-4">
                                            Email
                                        </th>
                                        <th scope="col" class="px-6 py-4">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-4">
                                            Registered Date
                                        </th>
<!--                                        <th-->
<!--                                            scope="col"-->
<!--                                            class="px-6 py-4 text-right"-->
<!--                                        >-->
<!--                                            Actions-->
<!--                                        </th>-->
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr
                                        v-for="user in filteredUsers"
                                        :key="user.id"
                                        class="transition-colors hover:bg-gray-50/80"
                                    >
                                        <td class="px-6 py-4">
                                            <div
                                                class="flex items-center gap-4"
                                            >
                                                <div>
                                                    <div
                                                        class="font-medium text-gray-900"
                                                    >
                                                        {{ user.name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-700">{{
                                                user.email
                                            }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                :class="[
                                                    'inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium',
                                                    user.status === 'Active'
                                                        ? 'bg-green-100 text-green-700'
                                                        : 'bg-red-100 text-red-700',
                                                ]"
                                            >
                                                <span
                                                    :class="[
                                                        'h-1.5 w-1.5 rounded-full',
                                                        user.status === 'Active'
                                                            ? 'bg-green-500'
                                                            : 'bg-red-500',
                                                    ]"
                                                ></span>
                                                {{ user.status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-500">
                                            {{ user.date }}
                                        </td>
<!--                                        <td class="px-6 py-4 text-right">-->
<!--                                            <div-->
<!--                                                class="flex items-center justify-end gap-3"-->
<!--                                            >-->
<!--                                                <button-->
<!--                                                    class="text-gray-400 transition-colors hover:text-indigo-600"-->
<!--                                                >-->
<!--                                                    <svg-->
<!--                                                        class="h-5 w-5"-->
<!--                                                        fill="none"-->
<!--                                                        viewBox="0 0 24 24"-->
<!--                                                        stroke="currentColor"-->
<!--                                                        stroke-width="2"-->
<!--                                                    >-->
<!--                                                        <path-->
<!--                                                            stroke-linecap="round"-->
<!--                                                            stroke-linejoin="round"-->
<!--                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"-->
<!--                                                        />-->
<!--                                                    </svg>-->
<!--                                                </button>-->
<!--                                                <button-->
<!--                                                    class="text-gray-400 transition-colors hover:text-red-600"-->
<!--                                                >-->
<!--                                                    <svg-->
<!--                                                        class="h-5 w-5"-->
<!--                                                        fill="none"-->
<!--                                                        viewBox="0 0 24 24"-->
<!--                                                        stroke="currentColor"-->
<!--                                                        stroke-width="2"-->
<!--                                                    >-->
<!--                                                        <path-->
<!--                                                            stroke-linecap="round"-->
<!--                                                            stroke-linejoin="round"-->
<!--                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"-->
<!--                                                        />-->
<!--                                                    </svg>-->
<!--                                                </button>-->
<!--                                            </div>-->
<!--                                        </td>-->
                                    </tr>

                                    <!-- Empty State (When search yields no results) -->
                                    <tr v-if="filteredUsers.length === 0">
                                        <td
                                            colspan="5"
                                            class="px-6 py-12 text-center text-gray-500"
                                        >
                                            <div
                                                class="flex flex-col items-center justify-center"
                                            >
                                                <svg
                                                    class="mb-3 h-10 w-10 text-gray-300"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                                    />
                                                </svg>
                                                <span class="text-sm"
                                                    >No users found matching "{{
                                                        searchQuery
                                                    }}"</span
                                                >
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Footer -->
                        <div
                            class="flex items-center justify-between border-t border-gray-200 bg-white px-6 py-4"
                        >
                            <span class="text-sm text-gray-500"
                                >Showing
                                <span class="font-medium text-gray-900">1</span>
                                to
                                <span class="font-medium text-gray-900">{{
                                    filteredUsers.length
                                }}</span>
                                of
                                <span class="font-medium text-gray-900">{{
                                    users.length
                                }}</span>
                                results</span
                            >
                            <div class="flex gap-2">
                                <button
                                    class="rounded-lg border border-gray-300 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50"
                                    disabled
                                >
                                    Previous
                                </button>
                                <button
                                    class="rounded-lg border border-gray-300 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
                                >
                                    Next
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
