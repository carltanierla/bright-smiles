<template>
    <Head title="Admin Login" />

    <div
        class="flex min-h-screen flex-col justify-center bg-slate-900 py-12 sm:px-6 lg:px-8"
    >
        <div class="sm:max-width-md sm:mx-auto sm:w-full sm:max-w-md">
            <h2
                class="mt-6 text-center text-3xl font-bold tracking-tight text-white"
            >
                Admin Portal
            </h2>
            <p class="mt-2 text-center text-sm text-slate-400">
                Sign in to manage patient records and clinic operations
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div
                class="border border-slate-700 bg-slate-800 px-4 py-8 shadow-2xl sm:rounded-xl sm:px-10"
            >
                <form class="space-y-6" @submit.prevent="submit">
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
                                autocomplete="email"
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
                                autocomplete="current-password"
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

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input
                                id="remember"
                                v-model="form.remember"
                                type="checkbox"
                                class="h-4 w-4 rounded border-slate-600 bg-slate-900 text-sky-600 focus:ring-sky-500"
                            />
                            <label
                                for="remember"
                                class="ml-2 block text-sm text-slate-300"
                            >
                                Remember me
                            </label>
                        </div>
                    </div>

                    <div>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="flex w-full justify-center rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 focus:ring-offset-slate-800 disabled:opacity-50"
                        >
                            <span v-if="form.processing">Signing in...</span>
                            <span v-else>Sign In</span>
                        </button>
                    </div>
                </form>

                <div class="mt-6 border-t border-slate-700 pt-6 text-center">
                    <p class="text-sm text-slate-400">
                        Need an admin account?
                        <Link
                            :href="route('admin.signup')"
                            class="font-medium text-sky-400 hover:text-sky-300"
                        >
                            Create Administrator
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
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('admin.login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>
