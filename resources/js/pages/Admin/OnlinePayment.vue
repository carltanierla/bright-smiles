<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted } from 'vue';
import AdminLayout from '@/Components/AdminLayout.vue';

// State Management
const payments = ref<any[]>([]);
const searchQuery = ref('');
const isLoading = ref(true);
const isProfileMenuOpen = ref(false);

// Image Lightbox Modal State
const previewImage = ref<string | null>(null);

// Context Menu State
const contextMenu = ref({
    isOpen: false,
    x: 0,
    y: 0,
    payment: null as any,
});

// Sidebar State
const sidebar = ref({
    isOpen: false,
    data: null as any,
});

// Dropdown Menus Visibility State
const isFilterOpen = ref(false);
const isSortOpen = ref(false);
const isColumnsOpen = ref(false);
const isActionsOpen = ref(false);

// Multi-selection State
const selectedPaymentIds = ref<number[]>([]);

// Filter State
const availableStatuses = ['Paid', 'Pending', 'Refunded'];
const selectedStatuses = ref<string[]>([]);
const filterSearch = ref('');

// Sort State
const sortKey = ref<string>('id');
const sortOrder = ref<'asc' | 'desc'>('desc');

// Columns Config & Visibility State - (Matched to Video)
const allColumns = [
    { key: 'id', label: 'ID' },
    { key: 'date_added', label: 'Added' },
    { key: 'submitted', label: 'Submitted' },
    { key: 'status', label: 'Status' },
    { key: 'order_summary', label: 'Order Summary' },
    { key: 'patient_name', label: "Patient's name" },
    { key: 'name_on_card', label: 'Name on Card' },
    { key: 'billing_address', label: 'Billing Address' },
    { key: 'email', label: 'Email' },
    { key: 'authorization', label: 'I authorize...' },
    { key: 'payment_for', label: 'Payment for' },
    { key: 'signature', label: 'Signature' },
];

const visibleColumnKeys = ref<string[]>([
    'id', 'date_added', 'order_summary', 'patient_name',
    'name_on_card', 'billing_address', 'email', 'payment_for', 'signature'
]);

const visibleColumns = computed(() => {
    return allColumns.filter((col) =>
        visibleColumnKeys.value.includes(col.key),
    );
});

// Profile Menu Handlers
const editProfile = () => {
    isProfileMenuOpen.value = false;
    router.visit('/admin/profile');
};

const logout = () => {
    isProfileMenuOpen.value = false;
    router.post('/admin/logout');
};

const fetchPayments = async () => {
    isLoading.value = true;
    try {
        const response = await fetch('/api/payments'); // Update to your actual API route
        if (!response.ok) throw new Error('Failed to fetch data');
        const data = await response.json();
        payments.value = Array.isArray(data) ? data : data.data || [];
    } catch (error) {
        console.error('Error fetching payments:', error);
        payments.value = [];
    } finally {
        isLoading.value = false;
    }
};

// Dropdown Toggles
const closeAllDropdowns = () => {
    isFilterOpen.value = false;
    isSortOpen.value = false;
    isColumnsOpen.value = false;
    isActionsOpen.value = false;
    isProfileMenuOpen.value = false;
};

const toggleDropdown = (
    menu: 'filter' | 'sort' | 'columns' | 'actions' | 'profile',
) => {
    const currentState = {
        filter: isFilterOpen.value,
        sort: isSortOpen.value,
        columns: isColumnsOpen.value,
        actions: isActionsOpen.value,
        profile: isProfileMenuOpen.value,
    }[menu];

    closeAllDropdowns();

    if (menu === 'filter') isFilterOpen.value = !currentState;
    if (menu === 'sort') isSortOpen.value = !currentState;
    if (menu === 'columns') isColumnsOpen.value = !currentState;
    if (menu === 'actions') isActionsOpen.value = !currentState;
    if (menu === 'profile') isProfileMenuOpen.value = !currentState;
};

const handleClickOutside = (e: MouseEvent) => {
    if (contextMenu.value.isOpen) contextMenu.value.isOpen = false;
    const target = e.target as HTMLElement;
    if (!target.closest('.relative-dropdown')) {
        closeAllDropdowns();
    }
};

onMounted(() => {
    fetchPayments();
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});

// Selection Logic
const isAllSelected = computed(() => {
    return (
        filteredPayments.value.length > 0 &&
        selectedPaymentIds.value.length === filteredPayments.value.length
    );
});

const toggleSelectAll = () => {
    if (isAllSelected.value) {
        selectedPaymentIds.value = [];
    } else {
        selectedPaymentIds.value = filteredPayments.value.map((p) => p.id);
    }
};

// Filter Functions
const toggleStatusFilter = (status: string) => {
    const index = selectedStatuses.value.indexOf(status);
    if (index > -1) {
        selectedStatuses.value.splice(index, 1);
    } else {
        selectedStatuses.value.push(status);
    }
};

const clearFilters = () => {
    selectedStatuses.value = [];
    filterSearch.value = '';
};

// Column Visibility Functions
const toggleColumn = (key: string) => {
    const index = visibleColumnKeys.value.indexOf(key);
    if (index > -1) {
        if (visibleColumnKeys.value.length > 1) {
            visibleColumnKeys.value.splice(index, 1);
        }
    } else {
        visibleColumnKeys.value.push(key);
    }
};

const selectAllColumns = () => {
    visibleColumnKeys.value = allColumns.map((c) => c.key);
};

// Actions Menu Handlers
const exportToCSV = () => {
    if (!filteredPayments.value.length) return;
    const exportData = selectedPaymentIds.value.length
        ? filteredPayments.value.filter((p) =>
            selectedPaymentIds.value.includes(p.id),
        )
        : filteredPayments.value;

    const headers = visibleColumns.value.map((col) => col.label).join(',');
    const rows = exportData.map((payment) =>
        visibleColumns.value
            .map((col) => {
                const val = payment[col.key] ?? '';
                return `"${String(val).replace(/"/g, '""')}"`;
            })
            .join(','),
    );

    const csvContent =
        'data:text/csv;charset=utf-8,' + [headers, ...rows].join('\n');
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement('a');
    link.setAttribute('href', encodedUri);
    link.setAttribute(
        'download',
        `online_payments_${new Date().toISOString().slice(0, 10)}.csv`,
    );
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    isActionsOpen.value = false;
};

const bulkUpdateStatus = async (newStatus: string) => {
    if (!selectedPaymentIds.value.length) return;

    payments.value.forEach((p) => {
        if (selectedPaymentIds.value.includes(p.id)) {
            p.status = newStatus;
        }
    });

    try {
        await Promise.all(
            selectedPaymentIds.value.map((id) =>
                fetch(`/api/payments/${id}`, {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ status: newStatus }),
                }),
            ),
        );
    } catch (e) {
        console.error('Failed to update status on server:', e);
    } finally {
        isActionsOpen.value = false;
    }
};

// Context Menu Logic
const openContextMenu = (event: MouseEvent, payment: any) => {
    contextMenu.value = {
        isOpen: true,
        x: event.clientX,
        y: event.clientY,
        payment: payment,
    };
};

const updateStatus = async (newStatus: string) => {
    if (contextMenu.value.payment) {
        const payment = contextMenu.value.payment;
        payment.status = newStatus;
        try {
            await fetch(`/api/payments/${payment.id}`, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ status: newStatus }),
            });
        } catch (e) {
            console.error('Failed to update status on server:', e);
        }
    }
    contextMenu.value.isOpen = false;
};

// Sidebar Handlers
const openSidebar = (payment: any) => {
    const raw = JSON.parse(JSON.stringify(payment));

    const getImageUrl = (path: string | null | undefined) => {
        if (!path) return null;
        if (path.startsWith('http') || path.startsWith('data:')) return path;
        return `/storage/${path}`;
    };

    sidebar.value.data = {
        ...raw,
        id: raw.id,
        patient_name: raw.patient_name || '',
        name_on_card: raw.name_on_card || '',
        status: raw.status || 'Paid',
        order_summary: raw.order_summary || '',
        email: raw.email || '',
        billing_address: raw.billing_address || '',
        authorization: raw.authorization || '',
        payment_for: raw.payment_for || '',
        signature: getImageUrl(raw.signature),
    };

    sidebar.value.isOpen = true;
};

const closeSidebar = () => {
    sidebar.value.isOpen = false;
    setTimeout(() => {
        sidebar.value.data = null;
    }, 300);
};

const saveSidebarData = async () => {
    try {
        if (sidebar.value.data.id) {
            await fetch(`/api/payments/${sidebar.value.data.id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(sidebar.value.data),
            });
        }
        const index = payments.value.findIndex(
            (p) => p.id === sidebar.value.data.id,
        );
        if (index !== -1) {
            payments.value[index] = { ...sidebar.value.data };
        }
    } catch (error) {
        console.error('Error saving payment data:', error);
    } finally {
        closeSidebar();
    }
};

const openImageModal = (src: string) => {
    if (src) previewImage.value = src;
};

const closeImageModal = () => {
    previewImage.value = null;
};

const handlePrint = () => {
    window.print();
};

const getStatusClass = (status: string) => {
    switch (status?.toLowerCase()) {
        case 'paid':
            return 'bg-green-100 text-green-800 border-green-200';
        case 'pending':
            return 'bg-yellow-100 text-yellow-800 border-yellow-200';
        case 'refunded':
            return 'bg-gray-100 text-gray-800 border-gray-200';
        default:
            return 'bg-blue-100 text-blue-800 border-blue-200';
    }
};

// Computed Filtered & Sorted List
const filteredPayments = computed(() => {
    let result = [...payments.value];

    // 1. Text Search Query
    if (searchQuery.value) {
        const lowerQuery = searchQuery.value.toLowerCase();
        result = result.filter(
            (p: any) =>
                (p.patient_name &&
                    p.patient_name.toLowerCase().includes(lowerQuery)) ||
                (p.name_on_card &&
                    p.name_on_card.toLowerCase().includes(lowerQuery)) ||
                (p.email && p.email.toLowerCase().includes(lowerQuery)),
        );
    }

    // 2. Status Filters
    if (selectedStatuses.value.length > 0) {
        result = result.filter((p: any) =>
            selectedStatuses.value.includes(p.status || 'Paid'),
        );
    }

    // 3. Sorting
    if (sortKey.value) {
        result.sort((a, b) => {
            let valA = a[sortKey.value] ?? '';
            let valB = b[sortKey.value] ?? '';

            if (typeof valA === 'string') valA = valA.toLowerCase();
            if (typeof valB === 'string') valB = valB.toLowerCase();

            if (valA < valB) return sortOrder.value === 'asc' ? -1 : 1;
            if (valA > valB) return sortOrder.value === 'asc' ? 1 : -1;
            return 0;
        });
    }

    return result;
});
</script>

<template>
    <AdminLayout>
        <div
            class="relative flex h-screen overflow-hidden bg-gray-50 font-sans text-gray-900 print:block print:h-auto print:overflow-visible print:bg-white"
        >
            <!-- Image Lightbox Modal -->
            <transition name="fade">
                <div
                    v-if="previewImage"
                    @click="closeImageModal"
                    class="backdrop-blur-xs fixed inset-0 z-50 flex items-center justify-center bg-black/75 p-4 print:hidden"
                >
                    <div
                        class="relative max-h-[90vh] max-w-4xl overflow-hidden rounded-lg bg-white p-2 shadow-2xl"
                        @click.stop
                    >
                        <button
                            @click="closeImageModal"
                            type="button"
                            class="absolute right-3 top-3 z-10 rounded-full bg-white/90 p-1.5 text-gray-600 shadow hover:bg-gray-200"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                ></path>
                            </svg>
                        </button>
                        <img
                            :src="previewImage"
                            alt="Preview"
                            class="max-h-[85vh] max-w-full rounded object-contain"
                        />
                    </div>
                </div>
            </transition>

            <!-- Context Menu -->
            <div
                v-if="contextMenu.isOpen"
                :style="{
                    top: contextMenu.y + 'px',
                    left: contextMenu.x + 'px',
                }"
                class="fixed z-50 w-48 rounded-md border border-gray-200 bg-white py-1 text-sm text-gray-700 shadow-xl print:hidden"
            >
                <div
                    class="border-b border-gray-100 px-3 py-2 text-xs font-semibold uppercase tracking-wider text-gray-500"
                >
                    Change Status
                </div>
                <button
                    @click="updateStatus('Paid')"
                    class="flex w-full items-center gap-2 px-4 py-2 text-left hover:bg-gray-50"
                >
                    <span class="h-2 w-2 rounded-full bg-green-500"></span>
                    Paid
                </button>
                <button
                    @click="updateStatus('Pending')"
                    class="flex w-full items-center gap-2 px-4 py-2 text-left hover:bg-gray-50"
                >
                    <span class="h-2 w-2 rounded-full bg-yellow-500"></span>
                    Pending
                </button>
                <button
                    @click="updateStatus('Refunded')"
                    class="flex w-full items-center gap-2 px-4 py-2 text-left hover:bg-gray-50"
                >
                    <span class="h-2 w-2 rounded-full bg-gray-500"></span>
                    Refunded
                </button>
                <div class="my-1 border-t border-gray-100"></div>
                <button
                    @click="
                        openSidebar(contextMenu.payment);
                        contextMenu.isOpen = false;
                    "
                    class="w-full px-4 py-2 text-left text-indigo-600 hover:bg-gray-50"
                >
                    View Details
                </button>
            </div>

            <!-- Dashboard Content -->
            <div class="flex flex-1 flex-col overflow-hidden print:hidden">
                <header
                    class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 bg-white px-6 py-4 shadow-sm"
                >
                    <h1 class="text-xl font-bold text-gray-800">
                        Admin Dashboard - Online Payments
                    </h1>

                    <!-- Action Toolbar Buttons -->
                    <div class="flex flex-wrap items-center gap-3">
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Search payments..."
                            class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-indigo-500 focus:outline-none"
                        />

                        <!-- Filter Dropdown -->
                        <div class="relative-dropdown relative">
                            <button
                                @click="toggleDropdown('filter')"
                                class="flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                            >
                                <svg
                                    class="h-4 w-4 text-gray-500"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"
                                    />
                                </svg>
                                Filter
                                <span
                                    v-if="selectedStatuses.length"
                                    class="ml-1 rounded-full bg-indigo-100 px-1.5 py-0.5 text-xs font-semibold text-indigo-600"
                                >
                                    {{ selectedStatuses.length }}
                                </span>
                            </button>

                            <div
                                v-if="isFilterOpen"
                                class="absolute right-0 z-30 mt-2 w-64 rounded-lg border border-gray-200 bg-white p-3 shadow-xl"
                            >
                                <div
                                    class="mb-2 text-xs font-semibold uppercase tracking-wider text-gray-500"
                                >
                                    Filter by Status
                                </div>
                                <div class="mb-3 space-y-2">
                                    <label
                                        v-for="status in availableStatuses"
                                        :key="status"
                                        class="flex cursor-pointer items-center gap-2 text-sm text-gray-700"
                                    >
                                        <input
                                            type="checkbox"
                                            :checked="
                                                selectedStatuses.includes(
                                                    status,
                                                )
                                            "
                                            @change="toggleStatusFilter(status)"
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                        />
                                        {{ status }}
                                    </label>
                                </div>
                                <div
                                    class="flex items-center justify-between border-t border-gray-100 pt-2"
                                >
                                    <button
                                        @click="clearFilters"
                                        class="text-xs text-gray-500 hover:text-gray-800"
                                    >
                                        Clear
                                    </button>
                                    <button
                                        @click="isFilterOpen = false"
                                        class="rounded bg-indigo-600 px-2.5 py-1 text-xs text-white hover:bg-indigo-700"
                                    >
                                        Apply
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Sort Dropdown -->
                        <div class="relative-dropdown relative">
                            <button
                                @click="toggleDropdown('sort')"
                                class="flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                            >
                                <svg
                                    class="h-4 w-4 text-gray-500"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"
                                    />
                                </svg>
                                Sort
                            </button>

                            <div
                                v-if="isSortOpen"
                                class="absolute right-0 z-30 mt-2 w-60 rounded-lg border border-gray-200 bg-white p-3 shadow-xl"
                            >
                                <div
                                    class="mb-2 text-xs font-semibold uppercase tracking-wider text-gray-500"
                                >
                                    Sort Field
                                </div>
                                <select
                                    v-model="sortKey"
                                    class="mb-3 w-full rounded border border-gray-300 p-1.5 text-xs"
                                >
                                    <option
                                        v-for="col in allColumns"
                                        :key="col.key"
                                        :value="col.key"
                                    >
                                        {{ col.label }}
                                    </option>
                                </select>

                                <div
                                    class="mb-2 text-xs font-semibold uppercase tracking-wider text-gray-500"
                                >
                                    Order
                                </div>
                                <div class="mb-3 flex items-center gap-4">
                                    <label
                                        class="flex cursor-pointer items-center gap-1 text-xs"
                                    ><input
                                        type="radio"
                                        value="asc"
                                        v-model="sortOrder"
                                    />
                                        Ascending</label
                                    >
                                    <label
                                        class="flex cursor-pointer items-center gap-1 text-xs"
                                    ><input
                                        type="radio"
                                        value="desc"
                                        v-model="sortOrder"
                                    />
                                        Descending</label
                                    >
                                </div>

                                <div
                                    class="flex items-center justify-between border-t border-gray-100 pt-2"
                                >
                                    <button
                                        @click="
                                            sortKey = 'id';
                                            sortOrder = 'desc';
                                        "
                                        class="text-xs text-gray-500 hover:text-gray-800"
                                    >
                                        Reset
                                    </button>
                                    <button
                                        @click="isSortOpen = false"
                                        class="rounded bg-indigo-600 px-2.5 py-1 text-xs text-white hover:bg-indigo-700"
                                    >
                                        Apply
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Columns Dropdown -->
                        <div class="relative-dropdown relative">
                            <button
                                @click="toggleDropdown('columns')"
                                class="flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                            >
                                <svg
                                    class="h-4 w-4 text-gray-500"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2m0 10V7"
                                    />
                                </svg>
                                Columns
                            </button>

                            <div
                                v-if="isColumnsOpen"
                                class="absolute right-0 z-30 mt-2 max-h-72 w-56 overflow-y-auto rounded-lg border border-gray-200 bg-white p-3 shadow-xl"
                            >
                                <div
                                    class="mb-2 text-xs font-semibold uppercase tracking-wider text-gray-500"
                                >
                                    Toggle Columns
                                </div>
                                <div class="mb-3 space-y-1.5">
                                    <label
                                        v-for="col in allColumns"
                                        :key="col.key"
                                        class="flex cursor-pointer items-center gap-2 text-sm text-gray-700"
                                    >
                                        <input
                                            type="checkbox"
                                            :checked="
                                                visibleColumnKeys.includes(
                                                    col.key,
                                                )
                                            "
                                            @change="toggleColumn(col.key)"
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                        />
                                        {{ col.label }}
                                    </label>
                                </div>
                                <div class="border-t border-gray-100 pt-2">
                                    <button
                                        @click="selectAllColumns"
                                        class="text-xs text-indigo-600 hover:underline"
                                    >
                                        Show All
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Actions Dropdown -->
                        <div class="relative-dropdown relative">
                            <button
                                @click="toggleDropdown('actions')"
                                class="flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                            >
                                <svg
                                    class="h-4 w-4 text-gray-500"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"
                                    />
                                </svg>
                                Actions
                            </button>

                            <div
                                v-if="isActionsOpen"
                                class="absolute right-0 z-30 mt-2 w-52 rounded-lg border border-gray-200 bg-white py-1 text-sm text-gray-700 shadow-xl"
                            >
                                <button
                                    @click="exportToCSV"
                                    class="flex w-full items-center gap-2 px-4 py-2 text-left hover:bg-gray-50"
                                >
                                    <svg
                                        class="h-4 w-4 text-gray-500"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0l-4-4m4 4V4"
                                        />
                                    </svg>
                                    Export CSV
                                </button>
                                <div
                                    class="my-1 border-t border-gray-100"
                                ></div>
                                <div
                                    class="px-3 py-1 text-xs font-semibold uppercase tracking-wider text-gray-400"
                                >
                                    Bulk Status
                                </div>
                                <button
                                    @click="bulkUpdateStatus('Paid')"
                                    :disabled="!selectedPaymentIds.length"
                                    class="flex w-full items-center gap-2 px-4 py-2 text-left hover:bg-gray-50 disabled:opacity-50"
                                >
                                    Mark as Paid
                                </button>
                                <button
                                    @click="bulkUpdateStatus('Pending')"
                                    :disabled="!selectedPaymentIds.length"
                                    class="flex w-full items-center gap-2 px-4 py-2 text-left hover:bg-gray-50 disabled:opacity-50"
                                >
                                    Mark as Pending
                                </button>
                            </div>
                        </div>

                        <!-- Profile Circle Menu Dropdown -->
                        <div
                            class="relative-dropdown relative ml-2 border-l border-gray-200 pl-4"
                        >
                            <button
                                @click="toggleDropdown('profile')"
                                class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 shadow-sm transition hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            >
                                <span class="text-sm font-bold">A</span>
                            </button>

                            <div
                                v-if="isProfileMenuOpen"
                                class="absolute right-0 z-30 mt-2 w-48 rounded-lg border border-gray-200 bg-white py-1 shadow-xl"
                            >
                                <button
                                    @click="editProfile"
                                    class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50"
                                >
                                    <svg
                                        class="h-4 w-4 text-gray-500"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                        ></path>
                                    </svg>
                                    Edit Profile
                                </button>
                                <div
                                    class="my-1 border-t border-gray-100"
                                ></div>
                                <button
                                    @click="logout"
                                    class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50"
                                >
                                    <svg
                                        class="h-4 w-4 text-red-500"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                        ></path>
                                    </svg>
                                    Logout
                                </button>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 overflow-y-auto p-6">
                    <div
                        class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm"
                    >
                        <table class="w-full text-left text-sm text-gray-600">
                            <thead
                                class="border-b border-gray-200 bg-gray-50 text-xs uppercase text-gray-500"
                            >
                            <tr>
                                <th class="px-4 py-3 text-center">
                                    <input
                                        type="checkbox"
                                        :checked="isAllSelected"
                                        @change="toggleSelectAll"
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    />
                                </th>
                                <th
                                    v-for="col in visibleColumns"
                                    :key="col.key"
                                    class="whitespace-nowrap px-6 py-3 font-medium"
                                >
                                    {{ col.label }}
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            <tr
                                v-for="payment in filteredPayments"
                                :key="payment.id"
                                @dblclick="openSidebar(payment)"
                                class="cursor-pointer transition-colors hover:bg-gray-50"
                            >
                                <td
                                    class="px-4 py-4 text-center"
                                    @click.stop
                                >
                                    <input
                                        type="checkbox"
                                        :value="payment.id"
                                        v-model="selectedPaymentIds"
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    />
                                </td>
                                <td
                                    v-for="col in visibleColumns"
                                    :key="col.key"
                                    class="whitespace-nowrap px-6 py-4"
                                >
                                    <template v-if="col.key === 'id'">
                                            <span
                                                class="font-medium text-gray-900"
                                            >#{{ payment.id }}</span
                                            >
                                    </template>
                                    <template v-else-if="col.key === 'status'">
                                            <span
                                                @contextmenu.prevent="
                                                    openContextMenu(
                                                        $event,
                                                        payment,
                                                    )
                                                "
                                                :class="[
                                                    'inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold',
                                                    getStatusClass(
                                                        payment.status,
                                                    ),
                                                ]"
                                            >
                                                {{ payment.status || 'Paid' }}
                                            </span>
                                    </template>
                                    <template v-else-if="col.key === 'signature'">
                                        <img v-if="payment.signature" :src="payment.signature" class="h-6 object-contain" alt="Signature"/>
                                        <span v-else>-</span>
                                    </template>
                                    <template v-else>
                                        {{ payment[col.key] || '-' }}
                                    </template>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </main>
            </div>

            <!-- Sidebar Overlay -->
            <transition name="fade">
                <div
                    v-if="sidebar.isOpen"
                    @click="closeSidebar"
                    class="backdrop-blur-xs fixed inset-0 z-40 bg-gray-900/30 print:hidden"
                ></div>
            </transition>

            <!-- Sidebar Panel -->
            <transition name="slide">
                <div
                    v-if="sidebar.isOpen"
                    class="fixed inset-y-0 right-0 z-50 flex w-full transform flex-col bg-white shadow-2xl transition-transform duration-300 md:max-w-2xl print:relative print:inset-auto print:z-auto print:h-auto print:w-full print:max-w-none print:transform-none print:overflow-visible print:shadow-none"
                >
                    <div
                        class="flex items-center justify-between border-b border-gray-200 bg-gray-50 px-6 py-4"
                    >
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                {{ sidebar.data.patient_name }}
                            </h3>
                            <span class="text-xs text-gray-500"
                            >Entry #{{ sidebar.data.id }}</span
                            >
                        </div>
                        <div class="flex items-center gap-2 print:hidden">
                            <button
                                type="button"
                                @click="handlePrint"
                                class="rounded border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
                            >
                                Print
                            </button>
                            <button
                                @click="closeSidebar"
                                type="button"
                                class="rounded-full p-2 text-gray-400 hover:bg-gray-200 hover:text-gray-600"
                            >
                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    ></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div
                        class="flex-1 overflow-y-auto bg-gray-50 p-6 print:h-auto print:overflow-visible print:bg-white print:p-2"
                    >
                        <form
                            @submit.prevent="saveSidebarData"
                            class="space-y-6"
                            v-if="sidebar.data"
                        >
                            <!-- Payment Status -->
                            <div
                                class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm print:border-none print:shadow-none"
                            >
                                <label
                                    class="mb-2 block text-sm font-semibold text-gray-900"
                                >Payment Status</label
                                >
                                <select
                                    v-model="sidebar.data.status"
                                    class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm"
                                >
                                    <option value="Paid">Paid</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Refunded">Refunded</option>
                                </select>
                            </div>

                            <!-- Payment Details -->
                            <div
                                class="space-y-4 rounded-lg border border-gray-200 bg-white p-5 shadow-sm print:border-none print:shadow-none"
                            >
                                <h4
                                    class="border-b border-gray-100 pb-2 text-sm font-semibold text-gray-900"
                                >
                                    Payment Details
                                </h4>
                                <div
                                    class="grid grid-cols-1 gap-4 sm:grid-cols-2"
                                >
                                    <div class="sm:col-span-2">
                                        <label
                                            class="mb-1 block text-xs font-medium text-gray-500"
                                        >Payment For</label
                                        >
                                        <input
                                            v-model="sidebar.data.payment_for"
                                            type="text"
                                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                        />
                                    </div>
                                    <div>
                                        <label
                                            class="mb-1 block text-xs font-medium text-gray-500"
                                        >Order Summary</label
                                        ><input
                                        v-model="sidebar.data.order_summary"
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                    </div>
                                    <div>
                                        <label
                                            class="mb-1 block text-xs font-medium text-gray-500"
                                        >Patient's Name</label
                                        ><input
                                        v-model="sidebar.data.patient_name"
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                    </div>
                                    <div>
                                        <label
                                            class="mb-1 block text-xs font-medium text-gray-500"
                                        >Name on Card</label
                                        ><input
                                        v-model="sidebar.data.name_on_card"
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                    </div>
                                    <div>
                                        <label
                                            class="mb-1 block text-xs font-medium text-gray-500"
                                        >Email</label
                                        ><input
                                        v-model="sidebar.data.email"
                                        type="email"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label
                                            class="mb-1 block text-xs font-medium text-gray-500"
                                        >Billing Address</label
                                        ><input
                                        v-model="sidebar.data.billing_address"
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                    </div>
                                </div>
                            </div>

                            <!-- Authorization & Signature -->
                            <div
                                class="space-y-4 rounded-lg border border-gray-200 bg-white p-5 shadow-sm print:border-none print:shadow-none"
                            >
                                <h4
                                    class="border-b border-gray-100 pb-2 text-sm font-semibold text-gray-900"
                                >
                                    Authorization & Signature
                                </h4>
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                    >Authorization</label
                                    >
                                    <textarea
                                        v-model="sidebar.data.authorization"
                                        rows="2"
                                        class="w-full rounded-md border border-gray-300 p-2 text-sm"
                                    ></textarea>
                                </div>
                                <div class="border-t border-gray-100 pt-3">
                                    <label
                                        class="mb-2 block text-xs font-semibold text-gray-700"
                                    >Signature:</label
                                    >
                                    <div
                                        v-if="sidebar.data.signature"
                                        class="inline-block rounded-lg border border-gray-200 bg-gray-50 p-2"
                                    >
                                        <img
                                            :src="sidebar.data.signature"
                                            alt="Authorization Signature"
                                            class="h-20 cursor-pointer object-contain hover:opacity-95"
                                            @click="
                                                openImageModal(
                                                    sidebar.data.signature,
                                                )
                                            "
                                        />
                                    </div>
                                    <span
                                        v-else
                                        class="text-xs italic text-gray-400"
                                    >No signature recorded.</span
                                    >
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div
                                class="flex justify-end gap-3 border-t border-gray-200 pt-4 print:hidden"
                            >
                                <button
                                    type="button"
                                    @click="closeSidebar"
                                    class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700"
                                >
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </transition>
        </div>
    </AdminLayout>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
.slide-enter-active,
.slide-leave-active {
    transition: transform 0.3s ease;
}
.slide-enter-from,
.slide-leave-to {
    transform: translateX(100%);
}
</style>
