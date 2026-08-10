<template>
    <Head title="Admin Sign Up" />

    <div
        class="flex min-h-screen flex-col justify-center bg-slate-900 py-12 sm:px-6 lg:px-8"
    >
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2
                class="mt-6 text-center text-3xl font-bold tracking-tight text-white"
            >
                Create Admin Account
            </h2>
            <p class="mt-2 text-center text-sm text-slate-400">
                Register a new administrator for Bright Smiles Orthodontics
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div
                class="border border-slate-700 bg-slate-800 px-4 py-8 shadow-2xl sm:rounded-xl sm:px-10"
            >
                <form class="space-y-5" @submit.prevent="submit">
                    <div>
                        <label
                            for="name"
                            class="block text-sm font-medium text-slate-200"
                        >
                            Full Name
                        </label>
                        <div class="mt-1">
                            <input
                                id="name"
                                v-model="form.name"
                                type="text"
                                required
                                class="block w-full rounded-lg border border-slate-600 bg-slate-900 px-3 py-2 text-white placeholder-slate-500 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 sm:text-sm"
                                :class="{ 'border-red-500': form.errors.name }"
                            />
                        </div>
                        <p
                            v-if="form.errors.name"
                            class="mt-2 text-sm text-red-400"
                        >
                            {{ form.errors.name }}
                        </p>
                    </div>

                    <div>
                        <label
                            for="email"
                            class="block text-sm font-medium text-slate-200"
                        >
                            Email Address
                        </label>
                        <div class="mt-1">
                            <input
                                id="email"
                                v-model="form.email"
                                type="email"
                                required
                                class="block w-full rounded-lg border border-slate-600 bg-slate-900 px-3 py-2 text-white placeholder-slate-500 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 sm:text-sm"
                                :class="{ 'border-red-500': form.errors.email }"
                            />
                        </div>
                        <p
                            v-if="form.errors.email"
                            class="mt-2 text-sm text-red-400"
                        >
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <div>
                        <label
                            for="password"
                            class="block text-sm font-medium text-slate-200"
                        >
                            Password
                        </label>
                        <div class="mt-1">
                            <input
                                id="password"
                                v-model="form.password"
                                type="password"
                                required
                                class="block w-full rounded-lg border border-slate-600 bg-slate-900 px-3 py-2 text-white placeholder-slate-500 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 sm:text-sm"
                                :class="{
                                    'border-red-500': form.errors.password,
                                }"
                            />
                        </div>
                        <p
                            v-if="form.errors.password"
                            class="mt-2 text-sm text-red-400"
                        >
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <div>
                        <label
                            for="password_confirmation"
                            class="block text-sm font-medium text-slate-200"
                        >
                            Confirm Password
                        </label>
                        <div class="mt-1">
                            <input
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                type="password"
                                required
                                class="block w-full rounded-lg border border-slate-600 bg-slate-900 px-3 py-2 text-white placeholder-slate-500 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 sm:text-sm"
                            />
                        </div>
                    </div>

                    <div>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="flex w-full justify-center rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 focus:ring-offset-slate-800 disabled:opacity-50"
                        >
                            <span v-if="form.processing"
                                >Creating Account...</span
                            >
                            <span v-else>Register Administrator</span>
                        </button>
                    </div>
                </form>

                <div class="mt-6 border-t border-slate-700 pt-6 text-center">
                    <p class="text-sm text-slate-400">
                        Already have an admin account?
                        <Link
                            :href="route('admin.login')"
                            class="font-medium text-sky-400 hover:text-sky-300"
                        >
                            Sign In
                        </Link>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('admin.signup'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
