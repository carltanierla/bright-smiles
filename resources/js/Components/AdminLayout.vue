<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex h-screen w-full overflow-hidden bg-gray-50">
        <!-- Right Navigation Sidebar -->
        <!-- Note: Change 'border-l' to 'border-r' if you move this above <main> for a Left Sidebar -->
        <aside
            class="flex w-64 flex-col border-l border-gray-200 bg-white shadow-sm"
        >
            <!-- Logo / Header -->
            <div
                class="flex h-16 items-center justify-center border-b border-gray-200 px-4"
            >
                <img
                    src="/images/BrightSmiles.png"
                    onerror="
                        this.onerror = null;
                        this.src =
                            'https://static.wixstatic.com/media/dd7742_f822f1d52c2e4135bdab54e19596ee94~mv2.jpg/v1/crop/x_0,y_126,w_1192,h_288/fill/w_466,h_112,al_c,q_80,usm_0.66_1.00_0.01,enc_avif,quality_auto/Bright%20Smiles%20Orthodontic%20Service_JPG.jpg';
                    "
                    alt="Bright Smiles"
                    class="h-9 w-auto object-contain"
                />
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 space-y-2 p-4">
                <Link
                    href="/admin/dashboard"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-700 transition-colors hover:bg-indigo-50 hover:text-indigo-600"
                >
                    <i class="fa-brands fa-wpforms"></i>
                    <span class="font-medium">Online Form</span>
                </Link>

                <Link
                    href="/admin/payments"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-700 transition-colors hover:bg-indigo-50 hover:text-indigo-600"
                >
                    <i class="fa-brands fa-stripe"></i>
                    <span class="font-medium">Online Payments</span>
                </Link>
            </nav>
        </aside>
        <!-- Main Content Area -->
        <main class="flex-1 overflow-hidden p-6">
            <!-- The specific page content will be injected here -->
            <slot />
        </main>
    </div>
</template>
