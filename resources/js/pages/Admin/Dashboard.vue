<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted } from 'vue';

// State Management
const users = ref<any[]>([]);
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
    user: null as any,
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
const selectedUserIds = ref<number[]>([]);

// Filter State
const availableStatuses = ['Submitted', 'Downloaded', 'Incomplete'];
const selectedStatuses = ref<string[]>([]);
const filterSearch = ref('');

// Sort State
const sortKey = ref<string>('id');
const sortOrder = ref<'asc' | 'desc'>('desc');

// Columns Config & Visibility State
const allColumns = [
    { key: 'id', label: 'ID' },
    { key: 'patient_status', label: 'Status' },
    { key: 'first_name', label: 'First Name' },
    { key: 'last_name', label: 'Last Name' },
    { key: 'sex', label: 'Sex' },
    { key: 'dob', label: 'DOB' },
    { key: 'mobile_number', label: 'Mobile' },
    { key: 'email', label: 'Email' },
    { key: 'general_dentist', label: 'General Dentist' },
];

const visibleColumnKeys = ref<string[]>(allColumns.map((col) => col.key));

const visibleColumns = computed(() => {
    return allColumns.filter((col) =>
        visibleColumnKeys.value.includes(col.key),
    );
});

// Consent Forms Configuration
const consentSections = [
    { title: 'FINANCIAL CONSENT FORM', key: 'financialConsent1' },
    { title: 'INFORMED CONSENT FORM', key: 'informedConsent' },
    { title: 'FINANCIAL CONSENT', key: 'financialConsent2' },
    { title: 'APPOINTMENT POLICY', key: 'appointmentPolicy' },
];

// Medical Conditions Configuration
const medicalConditionsConfig = [
    {
        id: 'heartProblems',
        label: 'History of Heart Problems or Heart Surgery',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    {
        id: 'bloodPressure',
        label: 'Blood Pressure problems',
        extraType: 'select',
        extraLabel: 'Type:',
        options: [
            'High blood pressure under control with medications',
            'High blood pressure NOT under control',
            'Low blood pressure under control with medications',
            'Low blood pressure NOT under control',
        ],
    },
    {
        id: 'excessiveBruising',
        label: 'Excessive Bruising or Bleeding',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    {
        id: 'anaemia',
        label: 'Anaemia',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    {
        id: 'hepatitis',
        label: 'Hepatitis, Jaundice, or Liver Disease',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    {
        id: 'kidneyDisease',
        label: 'Kidney Disease',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    { id: 'diabetes', label: 'Diabetes', extraType: 'diabetes' },
    {
        id: 'boneDisorders',
        label: 'Bone Disorders (including Osteoporosis)',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    {
        id: 'jointSwelling',
        label: 'Joint swelling or pain (including Arthritis)',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    {
        id: 'epilepsy',
        label: 'Epilepsy / Seizures / Fainting / Dizziness',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    {
        id: 'thyroid',
        label: 'Thyroid Problems (including Goitre)',
        extraType: 'select',
        extraLabel: 'Type:',
        options: [
            'Hyper/over-active thyroid',
            'Hypo/under-active thyroid',
            'Other',
        ],
    },
    {
        id: 'tuberculosis',
        label: 'Tuberculosis / Asthma / Bronchitis / Lung Conditions',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    {
        id: 'anxiety',
        label: 'Anxiety / Depression',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    {
        id: 'cancer',
        label: 'Cancer or malignancy of any kind',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    {
        id: 'chemotherapy',
        label: 'Chemotherapy / Radiation therapy',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    {
        id: 'transplantedOrgan',
        label: 'Transplanted organ / bone marrow / stem cells',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    {
        id: 'sleepApnoea',
        label: 'Sleep Apnoea / Snoring / Breathing Issues',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    { id: 'speechProblems', label: 'Speech problems', extraType: 'speech' },
    {
        id: 'tonsilsRemoved',
        label: 'Tonsils Removed',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    {
        id: 'adenoidsRemoved',
        label: 'Adenoids Removed',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    {
        id: 'nasalObstruction',
        label: 'Nasal Obstruction',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    {
        id: 'earaches',
        label: 'Earaches',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
];

const dentalQuestions: Record<string, any> = {
    significantInjuries: {
        label: 'Significant injuries to the face, mouth, or teeth?',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    thumbSucking: {
        label: 'Thumb-sucking, finger or tongue habit?',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    grindTeeth: {
        label: 'Grind teeth/sore jaw/clench?',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    frequentBlisters: {
        label: 'Frequent blisters/canker sores?',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    extensiveDecay: {
        label: 'Extensive decay',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    previousExtractions: {
        label: 'Previous dental extractions',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    difficultySwallowing: {
        label: 'Difficulty swallowing or chewing',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    painClicking: {
        label: 'Pain or clicking of jaw',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    wisdomTeeth: {
        label: 'Are any of the inside wisdom teeth hot, cold, or highly loose/sensitive?',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
    },
    seeDentist: {
        label: 'Does the patient see a General Dentist regularly?',
        extraType: 'date',
        extraLabel: 'Approximate date of last visit:',
        alwaysShowExtra: true,
    },
    xrays6Months: { label: 'Have X-rays been taken within the last 6 months?' },
    seenOrthodontist: {
        label: 'Has the patient seen an Orthodontist before?',
        extraType: 'text',
        extraLabel: 'Details (Who, When, Status):',
    },
};

const photoFields = {
    frontal: 'Frontal face (lips relaxed/mouth closed)',
    smile: 'Smile face',
    side: 'Side View of Right side of face',
    teethFront: 'Teeth biting together from Front',
    teethRight: 'Teeth biting together from Right side',
    teethLeft: 'Teeth biting together from Left side',
    teethUpper: 'Upper teeth',
    teethLower: 'Lower teeth',
    xray1: 'X-ray 1 (Panorex/opg)',
    xray2: 'X-ray 2 (Side view of head/ceplametric)',
    referral: 'Picture of your referral (if you have one)',
};

const logout = () => {
    router.post('/admin/logout');
};

const fetchCustomers = async () => {
    isLoading.value = true;
    try {
        const response = await fetch('/api/customers');
        if (!response.ok) throw new Error('Failed to fetch data');
        const data = await response.json();
        users.value = Array.isArray(data) ? data : data.data || [];
    } catch (error) {
        console.error('Error fetching customers:', error);
        users.value = [];
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
};

const toggleDropdown = (menu: 'filter' | 'sort' | 'columns' | 'actions') => {
    const currentState = {
        filter: isFilterOpen.value,
        sort: isSortOpen.value,
        columns: isColumnsOpen.value,
        actions: isActionsOpen.value,
    }[menu];

    closeAllDropdowns();

    if (menu === 'filter') isFilterOpen.value = !currentState;
    if (menu === 'sort') isSortOpen.value = !currentState;
    if (menu === 'columns') isColumnsOpen.value = !currentState;
    if (menu === 'actions') isActionsOpen.value = !currentState;
};

const handleClickOutside = (e: MouseEvent) => {
    if (contextMenu.value.isOpen) contextMenu.value.isOpen = false;
    const target = e.target as HTMLElement;
    if (!target.closest('.relative-dropdown')) {
        closeAllDropdowns();
    }
};

onMounted(() => {
    fetchCustomers();
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});

// Selection Logic
const isAllSelected = computed(() => {
    return (
        filteredUsers.value.length > 0 &&
        selectedUserIds.value.length === filteredUsers.value.length
    );
});

const toggleSelectAll = () => {
    if (isAllSelected.value) {
        selectedUserIds.value = [];
    } else {
        selectedUserIds.value = filteredUsers.value.map((u) => u.id);
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
    if (!filteredUsers.value.length) return;
    const exportData = selectedUserIds.value.length
        ? filteredUsers.value.filter((u) =>
              selectedUserIds.value.includes(u.id),
          )
        : filteredUsers.value;

    const headers = visibleColumns.value.map((col) => col.label).join(',');
    const rows = exportData.map((user) =>
        visibleColumns.value
            .map((col) => {
                const val = user[col.key] ?? '';
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
        `patient_submissions_${new Date().toISOString().slice(0, 10)}.csv`,
    );
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    isActionsOpen.value = false;
};

const bulkUpdateStatus = async (newStatus: string) => {
    if (!selectedUserIds.value.length) return;

    users.value.forEach((u) => {
        if (selectedUserIds.value.includes(u.id)) {
            u.patient_status = newStatus;
        }
    });

    try {
        await Promise.all(
            selectedUserIds.value.map((id) =>
                fetch(`/api/customers/${id}`, {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ patient_status: newStatus }),
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
const openContextMenu = (event: MouseEvent, user: any) => {
    contextMenu.value = {
        isOpen: true,
        x: event.clientX,
        y: event.clientY,
        user: user,
    };
};

const updateStatus = async (newStatus: string) => {
    if (contextMenu.value.user) {
        const user = contextMenu.value.user;
        user.patient_status = newStatus;
        try {
            await fetch(`/api/customers/${user.id}`, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ patient_status: newStatus }),
            });
        } catch (e) {
            console.error('Failed to update status on server:', e);
        }
    }
    contextMenu.value.isOpen = false;
};

// Sidebar Handlers
const openSidebar = (user: any) => {
    const raw = JSON.parse(JSON.stringify(user));

    const getImageUrl = (path: string | null | undefined) => {
        if (!path) return null;
        if (path.startsWith('http') || path.startsWith('data:')) return path;
        return `/storage/${path}`;
    };

    // Map Photos
    const mappedPhotos: any = {};
    if (raw.photos) {
        if (raw.photos.frontal)
            mappedPhotos.frontal = getImageUrl(raw.photos.frontal);
        if (raw.photos.smile)
            mappedPhotos.smile = getImageUrl(raw.photos.smile);
        if (raw.photos.side) mappedPhotos.side = getImageUrl(raw.photos.side);
        if (raw.photos.teeth_front)
            mappedPhotos.teethFront = getImageUrl(raw.photos.teeth_front);
        if (raw.photos.teeth_right)
            mappedPhotos.teethRight = getImageUrl(raw.photos.teeth_right);
        if (raw.photos.teeth_left)
            mappedPhotos.teethLeft = getImageUrl(raw.photos.teeth_left);
        if (raw.photos.teeth_upper)
            mappedPhotos.teethUpper = getImageUrl(raw.photos.teeth_upper);
        if (raw.photos.teeth_lower)
            mappedPhotos.teethLower = getImageUrl(raw.photos.teeth_lower);
        if (raw.photos.xray_1)
            mappedPhotos.xray1 = getImageUrl(raw.photos.xray_1);
        if (raw.photos.xray_2)
            mappedPhotos.xray2 = getImageUrl(raw.photos.xray_2);
        if (raw.photos.referral)
            mappedPhotos.referral = getImageUrl(raw.photos.referral);
    }

    // Map Medical History
    const mappedMedical: any = {};
    const medHistory = raw.medical_history || {};
    medicalConditionsConfig.forEach((cond) => {
        const snakeKey = cond.id.replace(
            /[A-Z]/g,
            (letter) => `_${letter.toLowerCase()}`,
        );
        mappedMedical[cond.id] = {
            checked: !!medHistory[snakeKey],
            details: medHistory[`${snakeKey}_details`] || '',
            type: medHistory[`${snakeKey}_type`] || '',
            status: medHistory[`${snakeKey}_status`] || '',
        };
    });

    // Map Dental History
    const mappedDental: any = {};
    const denHistory = raw.dental_history || {};
    Object.keys(dentalQuestions).forEach((key) => {
        let snakeKey = key.replace(
            /[A-Z]/g,
            (letter) => `_${letter.toLowerCase()}`,
        );
        if (key === 'xrays6Months') snakeKey = 'xrays_6_months';

        mappedDental[key] = denHistory[snakeKey] ? 'Yes' : 'No';
        mappedDental[`${key}Details`] = denHistory[`${snakeKey}_details`] || '';
    });
    mappedDental.lastDentistVisit = denHistory.last_dentist_visit || '';

    sidebar.value.data = {
        ...raw,
        id: raw.id,
        first_name: raw.first_name || '',
        last_name: raw.last_name || '',
        patient_status: raw.patient_status || 'Submitted',
        sex: raw.sex || '',
        dob: raw.dob || '',
        mobile_number: raw.mobile_number || '',
        email: raw.email || '',
        financially_responsible: raw.is_financially_responsible ? 'Yes' : 'No',
        general_dentist: raw.general_dentist || '',
        familial_status: raw.familial_status || '',
        allergies: raw.medical_history?.allergies || raw.allergies || '',
        medications: raw.medical_history?.medications || raw.medications || '',
        additional_notes: raw.additional_notes || '',
        mailing_address: {
            line1: raw.mailing_address_line1 || '',
            line2: raw.mailing_address_line2 || '',
            suburb: raw.mailing_address_suburb || '',
            postCode: raw.mailing_address_postcode || '',
        },
        primary_party: {
            relationship: raw.primary_party_relationship || '',
            first_name: raw.primary_party_first_name || '',
            last_name: raw.primary_party_last_name || '',
            mobile: raw.primary_party_mobile || '',
            secondary_phone: raw.primary_party_secondary_phone || '',
            email: raw.primary_party_email || '',
            address: {
                line1: raw.primary_party_address_line1 || '',
                line2: raw.primary_party_address_line2 || '',
                suburb: raw.primary_party_address_suburb || '',
                postCode: raw.primary_party_address_postcode || '',
            },
        },
        secondary_party: {
            relationship: raw.secondary_party_relationship || '',
            first_name: raw.secondary_party_first_name || '',
            last_name: raw.secondary_party_last_name || '',
            mobile: raw.secondary_party_mobile || '',
            secondary_phone: raw.secondary_party_secondary_phone || '',
            same_as_primary: raw.secondary_party_same_as_primary ? 'Yes' : 'No',
            email: raw.secondary_party_email || '',
            release_info: raw.secondary_party_release_info ? 'Yes' : 'No',
            address: {
                line1: raw.secondary_party_address_line1 || '',
                line2: raw.secondary_party_address_line2 || '',
                suburb: raw.secondary_party_address_suburb || '',
                postCode: raw.secondary_party_address_postcode || '',
            },
        },
        insurance: {
            company: raw.insurance_company || '',
            hospital_cover: raw.insurance_hospital_cover || 'No',
            ortho_cover: raw.insurance_ortho_cover || '',
        },
        medical_history: mappedMedical,
        dental: mappedDental,
        signature: getImageUrl(raw.dental_history?.signature_path),
        consent_signatures: {
            financialConsent1: getImageUrl(
                raw.consent_forms?.financial_consent1_path,
            ),
            informedConsent: getImageUrl(
                raw.consent_forms?.informed_consent_path,
            ),
            financialConsent2: getImageUrl(
                raw.consent_forms?.financial_consent2_path,
            ),
            appointmentPolicy: getImageUrl(
                raw.consent_forms?.appointment_policy_path,
            ),
        },
        add_photos: raw.add_photos ? 'Yes' : 'No',
        photos: mappedPhotos,
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
            await fetch(`/api/customers/${sidebar.value.data.id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(sidebar.value.data),
            });
        }
        const index = users.value.findIndex(
            (u) => u.id === sidebar.value.data.id,
        );
        if (index !== -1) {
            users.value[index] = { ...sidebar.value.data };
        }
    } catch (error) {
        console.error('Error saving customer data:', error);
    } finally {
        closeSidebar();
    }
};

const handleSidebarFileUpload = (event: Event, key: string) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];
    if (file && sidebar.value.data) {
        const reader = new FileReader();
        reader.onload = (e) => {
            if (!sidebar.value.data.photos) sidebar.value.data.photos = {};
            sidebar.value.data.photos[key] = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    }
};

const removeSidebarPhoto = (key: string) => {
    if (sidebar.value.data?.photos) {
        delete sidebar.value.data.photos[key];
    }
};

const openImageModal = (src: string) => {
    if (src) previewImage.value = src;
};

const closeImageModal = () => {
    previewImage.value = null;
};

const getStatusClass = (status: string) => {
    switch (status?.toLowerCase()) {
        case 'submitted':
            return 'bg-green-100 text-green-800 border-green-200';
        case 'downloaded':
            return 'bg-blue-100 text-blue-800 border-blue-200';
        case 'incomplete':
            return 'bg-gray-100 text-gray-800 border-gray-200';
        default:
            return 'bg-gray-100 text-gray-800 border-gray-200';
    }
};

// Computed Filtered & Sorted List
const filteredUsers = computed(() => {
    let result = [...users.value];

    // 1. Text Search Query
    if (searchQuery.value) {
        const lowerQuery = searchQuery.value.toLowerCase();
        result = result.filter(
            (user: any) =>
                (user.first_name &&
                    user.first_name.toLowerCase().includes(lowerQuery)) ||
                (user.last_name &&
                    user.last_name.toLowerCase().includes(lowerQuery)) ||
                (user.email && user.email.toLowerCase().includes(lowerQuery)),
        );
    }

    // 2. Status Filters
    if (selectedStatuses.value.length > 0) {
        result = result.filter((user: any) =>
            selectedStatuses.value.includes(user.patient_status || 'Submitted'),
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
    <div
        class="relative flex h-screen overflow-hidden bg-gray-50 font-sans text-gray-900"
    >
        <!-- Image Lightbox Modal -->
        <transition name="fade">
            <div
                v-if="previewImage"
                @click="closeImageModal"
                class="backdrop-blur-xs fixed inset-0 z-50 flex items-center justify-center bg-black/75 p-4"
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
            :style="{ top: contextMenu.y + 'px', left: contextMenu.x + 'px' }"
            class="fixed z-50 w-48 rounded-md border border-gray-200 bg-white py-1 text-sm text-gray-700 shadow-xl"
        >
            <div
                class="border-b border-gray-100 px-3 py-2 text-xs font-semibold uppercase tracking-wider text-gray-500"
            >
                Change Status
            </div>
            <button
                @click="updateStatus('Submitted')"
                class="flex w-full items-center gap-2 px-4 py-2 text-left hover:bg-gray-50"
            >
                <span class="h-2 w-2 rounded-full bg-green-500"></span>
                Submitted
            </button>
            <button
                @click="updateStatus('Downloaded')"
                class="flex w-full items-center gap-2 px-4 py-2 text-left hover:bg-gray-50"
            >
                <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                Downloaded
            </button>
            <button
                @click="updateStatus('Incomplete')"
                class="flex w-full items-center gap-2 px-4 py-2 text-left hover:bg-gray-50"
            >
                <span class="h-2 w-2 rounded-full bg-gray-500"></span>
                Incomplete
            </button>
            <div class="my-1 border-t border-gray-100"></div>
            <button
                @click="
                    openSidebar(contextMenu.user);
                    contextMenu.isOpen = false;
                "
                class="w-full px-4 py-2 text-left text-indigo-600 hover:bg-gray-50"
            >
                Edit Entry
            </button>
        </div>

        <!-- Dashboard Content -->
        <div class="flex flex-1 flex-col overflow-hidden">
            <header
                class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 bg-white px-6 py-4 shadow-sm"
            >
                <h1 class="text-xl font-bold text-gray-800">
                    Admin Dashboard - Submissions
                </h1>

                <!-- Action Toolbar Buttons -->
                <div class="flex flex-wrap items-center gap-3">
                    <input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Search patients..."
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
                                            selectedStatuses.includes(status)
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
                                >
                                    <input
                                        type="radio"
                                        value="asc"
                                        v-model="sortOrder"
                                    />
                                    Ascending
                                </label>
                                <label
                                    class="flex cursor-pointer items-center gap-1 text-xs"
                                >
                                    <input
                                        type="radio"
                                        value="desc"
                                        v-model="sortOrder"
                                    />
                                    Descending
                                </label>
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
                                            visibleColumnKeys.includes(col.key)
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
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                    />
                                </svg>
                                Export CSV
                            </button>
                            <div class="my-1 border-t border-gray-100"></div>
                            <div
                                class="px-3 py-1 text-xs font-semibold uppercase tracking-wider text-gray-400"
                            >
                                Bulk Status
                            </div>
                            <button
                                @click="bulkUpdateStatus('Submitted')"
                                :disabled="!selectedUserIds.length"
                                class="flex w-full items-center gap-2 px-4 py-2 text-left hover:bg-gray-50 disabled:opacity-50"
                            >
                                Mark as Submitted
                            </button>
                            <button
                                @click="bulkUpdateStatus('Downloaded')"
                                :disabled="!selectedUserIds.length"
                                class="flex w-full items-center gap-2 px-4 py-2 text-left hover:bg-gray-50 disabled:opacity-50"
                            >
                                Mark as Downloaded
                            </button>
                        </div>
                    </div>

                    <button
                        @click="logout"
                        class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700"
                    >
                        Logout
                    </button>
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
                                    class="px-6 py-3 font-medium"
                                >
                                    {{ col.label }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr
                                v-for="user in filteredUsers"
                                :key="user.id"
                                @dblclick="openSidebar(user)"
                                class="cursor-pointer transition-colors hover:bg-gray-50"
                            >
                                <td class="px-4 py-4 text-center" @click.stop>
                                    <input
                                        type="checkbox"
                                        :value="user.id"
                                        v-model="selectedUserIds"
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    />
                                </td>
                                <td
                                    v-for="col in visibleColumns"
                                    :key="col.key"
                                    class="px-6 py-4"
                                >
                                    <template v-if="col.key === 'id'">
                                        <span class="font-medium text-gray-900"
                                            >#{{ user.id }}</span
                                        >
                                    </template>

                                    <template
                                        v-else-if="col.key === 'patient_status'"
                                    >
                                        <span
                                            @contextmenu.prevent="
                                                openContextMenu($event, user)
                                            "
                                            :class="[
                                                'inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold',
                                                getStatusClass(
                                                    user.patient_status,
                                                ),
                                            ]"
                                        >
                                            {{
                                                user.patient_status ||
                                                'Submitted'
                                            }}
                                        </span>
                                    </template>

                                    <template v-else>
                                        {{ user[col.key] || '-' }}
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
                class="backdrop-blur-xs fixed inset-0 z-40 bg-gray-900/30"
            ></div>
        </transition>

        <!-- Sidebar Panel -->
        <transition name="slide">
            <div
                v-if="sidebar.isOpen"
                class="fixed inset-y-0 right-0 z-50 flex w-full transform flex-col bg-white shadow-2xl transition-transform duration-300 md:max-w-2xl"
            >
                <div
                    class="flex items-center justify-between border-b border-gray-200 bg-gray-50 px-6 py-4"
                >
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ sidebar.data.first_name }}
                            {{ sidebar.data.last_name }}
                        </h3>
                        <span class="text-xs text-gray-500"
                            >Entry #{{ sidebar.data.id }}</span
                        >
                    </div>
                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            @click="window.print()"
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

                <div class="flex-1 overflow-y-auto bg-gray-50 p-6">
                    <form
                        @submit.prevent="saveSidebarData"
                        class="space-y-6"
                        v-if="sidebar.data"
                    >
                        <!-- Status -->
                        <div
                            class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm"
                        >
                            <label
                                class="mb-2 block text-sm font-semibold text-gray-900"
                                >Internal Status</label
                            >
                            <select
                                v-model="sidebar.data.patient_status"
                                class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm"
                            >
                                <option value="Submitted">Submitted</option>
                                <option value="Downloaded">Downloaded</option>
                                <option value="Incomplete">Incomplete</option>
                            </select>
                        </div>

                        <!-- Patient Details -->
                        <div
                            class="space-y-4 rounded-lg border border-gray-200 bg-white p-5 shadow-sm"
                        >
                            <h4
                                class="border-b border-gray-100 pb-2 text-sm font-semibold text-gray-900"
                            >
                                Patient Details
                            </h4>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >First Name</label
                                    >
                                    <input
                                        v-model="sidebar.data.first_name"
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >Last Name</label
                                    >
                                    <input
                                        v-model="sidebar.data.last_name"
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >Sex</label
                                    >
                                    <select
                                        v-model="sidebar.data.sex"
                                        class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm"
                                    >
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >DOB</label
                                    >
                                    <input
                                        v-model="sidebar.data.dob"
                                        type="date"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >Mobile</label
                                    >
                                    <input
                                        v-model="sidebar.data.mobile_number"
                                        type="tel"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >Email</label
                                    >
                                    <input
                                        v-model="sidebar.data.email"
                                        type="email"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >General Dentist</label
                                    >
                                    <input
                                        v-model="sidebar.data.general_dentist"
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >Financially Responsible?</label
                                    >
                                    <select
                                        v-model="
                                            sidebar.data.financially_responsible
                                        "
                                        class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm"
                                    >
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Mailing Address -->
                        <div
                            class="space-y-4 rounded-lg border border-gray-200 bg-white p-5 shadow-sm"
                        >
                            <h4
                                class="border-b border-gray-100 pb-2 text-sm font-semibold text-gray-900"
                            >
                                Mailing Address
                            </h4>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >Address Line 1</label
                                    >
                                    <input
                                        v-model="
                                            sidebar.data.mailing_address.line1
                                        "
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                                <div class="sm:col-span-2">
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >Address Line 2</label
                                    >
                                    <input
                                        v-model="
                                            sidebar.data.mailing_address.line2
                                        "
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >Suburb</label
                                    >
                                    <input
                                        v-model="
                                            sidebar.data.mailing_address.suburb
                                        "
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >Post Code</label
                                    >
                                    <input
                                        v-model="
                                            sidebar.data.mailing_address
                                                .postCode
                                        "
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Insurance Information -->
                        <div
                            class="space-y-4 rounded-lg border border-gray-200 bg-white p-5 shadow-sm"
                        >
                            <h4
                                class="border-b border-gray-100 pb-2 text-sm font-semibold text-gray-900"
                            >
                                Insurance Information
                            </h4>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >Insurance Company</label
                                    >
                                    <input
                                        v-model="sidebar.data.insurance.company"
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >Hospital Cover</label
                                    >
                                    <input
                                        v-model="
                                            sidebar.data.insurance
                                                .hospital_cover
                                        "
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >Orthodontic Cover</label
                                    >
                                    <input
                                        v-model="
                                            sidebar.data.insurance.ortho_cover
                                        "
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Primary Responsible Party -->
                        <div
                            class="space-y-4 rounded-lg border border-gray-200 bg-white p-5 shadow-sm"
                        >
                            <h4
                                class="border-b border-gray-100 pb-2 text-sm font-semibold text-gray-900"
                            >
                                Primary Responsible Party
                            </h4>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >Relationship</label
                                    >
                                    <input
                                        v-model="
                                            sidebar.data.primary_party
                                                .relationship
                                        "
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >First Name</label
                                    >
                                    <input
                                        v-model="
                                            sidebar.data.primary_party
                                                .first_name
                                        "
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >Last Name</label
                                    >
                                    <input
                                        v-model="
                                            sidebar.data.primary_party.last_name
                                        "
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >Mobile</label
                                    >
                                    <input
                                        v-model="
                                            sidebar.data.primary_party.mobile
                                        "
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >Secondary Phone</label
                                    >
                                    <input
                                        v-model="
                                            sidebar.data.primary_party
                                                .secondary_phone
                                        "
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >Email</label
                                    >
                                    <input
                                        v-model="
                                            sidebar.data.primary_party.email
                                        "
                                        type="email"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Secondary Responsible Party -->
                        <div
                            class="space-y-4 rounded-lg border border-gray-200 bg-white p-5 shadow-sm"
                        >
                            <h4
                                class="border-b border-gray-100 pb-2 text-sm font-semibold text-gray-900"
                            >
                                Secondary Responsible Party
                            </h4>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >Same as Primary?</label
                                    >
                                    <select
                                        v-model="
                                            sidebar.data.secondary_party
                                                .same_as_primary
                                        "
                                        class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm"
                                    >
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >Release Info?</label
                                    >
                                    <select
                                        v-model="
                                            sidebar.data.secondary_party
                                                .release_info
                                        "
                                        class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm"
                                    >
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >Relationship</label
                                    >
                                    <input
                                        v-model="
                                            sidebar.data.secondary_party
                                                .relationship
                                        "
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >First Name</label
                                    >
                                    <input
                                        v-model="
                                            sidebar.data.secondary_party
                                                .first_name
                                        "
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >Last Name</label
                                    >
                                    <input
                                        v-model="
                                            sidebar.data.secondary_party
                                                .last_name
                                        "
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-xs font-medium text-gray-500"
                                        >Mobile</label
                                    >
                                    <input
                                        v-model="
                                            sidebar.data.secondary_party.mobile
                                        "
                                        type="text"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Medical History Checklist -->
                        <div
                            class="space-y-4 rounded-lg border border-gray-200 bg-white p-5 shadow-sm"
                        >
                            <h4
                                class="border-b border-gray-100 pb-2 text-sm font-semibold text-gray-900"
                            >
                                Medical History
                            </h4>
                            <div
                                v-for="cond in medicalConditionsConfig"
                                :key="cond.id"
                                class="flex flex-col gap-2 border-b border-gray-100 pb-3"
                            >
                                <label
                                    class="flex items-center gap-2 text-sm text-gray-700"
                                >
                                    <input
                                        type="checkbox"
                                        v-model="
                                            sidebar.data.medical_history[
                                                cond.id
                                            ].checked
                                        "
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    />
                                    <span>{{ cond.label }}</span>
                                </label>
                                <div
                                    v-if="
                                        sidebar.data.medical_history[cond.id]
                                            .checked
                                    "
                                    class="pl-6"
                                >
                                    <input
                                        v-if="cond.extraType === 'text'"
                                        v-model="
                                            sidebar.data.medical_history[
                                                cond.id
                                            ].details
                                        "
                                        type="text"
                                        :placeholder="cond.extraLabel"
                                        class="w-full rounded-md border border-gray-300 px-3 py-1.5 text-xs"
                                    />
                                    <select
                                        v-if="cond.extraType === 'select'"
                                        v-model="
                                            sidebar.data.medical_history[
                                                cond.id
                                            ].type
                                        "
                                        class="w-full rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs"
                                    >
                                        <option
                                            v-for="opt in cond.options"
                                            :key="opt"
                                            :value="opt"
                                        >
                                            {{ opt }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label
                                    class="mb-1 block text-xs font-medium text-gray-500"
                                    >Allergies</label
                                >
                                <textarea
                                    v-model="sidebar.data.allergies"
                                    rows="2"
                                    class="w-full rounded-md border border-gray-300 p-2 text-sm"
                                ></textarea>
                            </div>
                            <div>
                                <label
                                    class="mb-1 block text-xs font-medium text-gray-500"
                                    >Current Medications</label
                                >
                                <textarea
                                    v-model="sidebar.data.medications"
                                    rows="2"
                                    class="w-full rounded-md border border-gray-300 p-2 text-sm"
                                ></textarea>
                            </div>
                        </div>

                        <!-- Dental History Questions -->
                        <div
                            class="space-y-4 rounded-lg border border-gray-200 bg-white p-5 shadow-sm"
                        >
                            <h4
                                class="border-b border-gray-100 pb-2 text-sm font-semibold text-gray-900"
                            >
                                Dental History
                            </h4>
                            <div
                                v-for="(q, key) in dentalQuestions"
                                :key="key"
                                class="flex flex-col gap-2 border-b border-gray-100 pb-3"
                            >
                                <span class="text-sm text-gray-700">{{
                                    q.label
                                }}</span>
                                <div class="flex items-center gap-4">
                                    <label
                                        class="flex items-center gap-1 text-xs"
                                        ><input
                                            type="radio"
                                            :name="key"
                                            value="Yes"
                                            v-model="sidebar.data.dental[key]"
                                        />
                                        Yes</label
                                    >
                                    <label
                                        class="flex items-center gap-1 text-xs"
                                        ><input
                                            type="radio"
                                            :name="key"
                                            value="No"
                                            v-model="sidebar.data.dental[key]"
                                        />
                                        No</label
                                    >
                                </div>
                                <div
                                    v-if="
                                        sidebar.data.dental[key] === 'Yes' &&
                                        q.extraType
                                    "
                                    class="pl-2"
                                >
                                    <input
                                        v-if="q.extraType === 'text'"
                                        v-model="
                                            sidebar.data.dental[key + 'Details']
                                        "
                                        type="text"
                                        :placeholder="q.extraLabel"
                                        class="w-full rounded-md border border-gray-300 px-3 py-1.5 text-xs"
                                    />
                                    <input
                                        v-if="q.extraType === 'date'"
                                        v-model="
                                            sidebar.data.dental.lastDentistVisit
                                        "
                                        type="date"
                                        class="w-full rounded-md border border-gray-300 px-3 py-1.5 text-xs"
                                    />
                                </div>
                            </div>

                            <!-- Dental Signature Display -->
                            <div class="border-t border-gray-100 pt-3">
                                <label
                                    class="mb-2 block text-xs font-semibold text-gray-700"
                                    >Patient / Guardian Signature:</label
                                >
                                <div
                                    v-if="sidebar.data.signature"
                                    class="inline-block rounded-lg border border-gray-200 bg-gray-50 p-2"
                                >
                                    <img
                                        :src="sidebar.data.signature"
                                        alt="Dental History Signature"
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

                        <!-- Photos & X-Rays -->
                        <div
                            v-if="sidebar.data.add_photos === 'Yes'"
                            class="space-y-4 rounded-lg border border-gray-200 bg-white p-5 shadow-sm"
                        >
                            <h4
                                class="border-b border-gray-100 pb-2 text-sm font-semibold text-gray-900"
                            >
                                Photos & X-rays
                            </h4>
                            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                                <div
                                    v-for="(label, key) in photoFields"
                                    :key="key"
                                    class="rounded border border-gray-200 p-2 text-center"
                                >
                                    <span
                                        class="mb-2 block truncate text-xs font-medium text-gray-600"
                                        :title="label"
                                        >{{ label }}</span
                                    >
                                    <div
                                        v-if="sidebar.data.photos?.[key]"
                                        class="group relative"
                                    >
                                        <img
                                            :src="sidebar.data.photos[key]"
                                            alt=""
                                            class="h-24 w-full cursor-pointer rounded object-cover"
                                            @click="
                                                openImageModal(
                                                    sidebar.data.photos[key],
                                                )
                                            "
                                        />
                                        <button
                                            @click.prevent="
                                                removeSidebarPhoto(key)
                                            "
                                            class="absolute right-1 top-1 rounded-full bg-red-600 p-1 text-white opacity-0 transition-opacity group-hover:opacity-100"
                                        >
                                            ✕
                                        </button>
                                    </div>
                                    <input
                                        v-else
                                        type="file"
                                        @change="
                                            handleSidebarFileUpload($event, key)
                                        "
                                        class="w-full text-xs"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Consent Forms Display -->
                        <div
                            class="space-y-4 rounded-lg border border-gray-200 bg-white p-5 shadow-sm"
                        >
                            <h4
                                class="border-b border-gray-100 pb-2 text-sm font-semibold text-gray-900"
                            >
                                Consent Forms
                            </h4>
                            <div
                                v-for="(consent, index) in consentSections"
                                :key="index"
                                class="overflow-hidden rounded-xl border border-gray-200 bg-white"
                            >
                                <div
                                    class="border-b border-gray-200 bg-slate-100 px-4 py-3"
                                >
                                    <h5
                                        class="text-sm font-bold text-slate-800"
                                    >
                                        {{ consent.title }}
                                    </h5>
                                </div>
                                <div class="space-y-4 p-4">
                                    <div
                                        class="overflow-hidden rounded-lg border border-slate-200 bg-slate-50 p-2"
                                    >
                                        <img
                                            :src="`/images/form/${consent.key}.JPG`"
                                            :alt="consent.title"
                                            class="w-full cursor-pointer object-contain hover:opacity-95"
                                            @click="
                                                openImageModal(
                                                    `/images/form/${consent.key}.JPG`,
                                                )
                                            "
                                        />
                                    </div>
                                    <p
                                        class="text-xs font-bold uppercase text-slate-800"
                                    >
                                        I HAVE READ AND UNDERSTOOD THE
                                        INFORMATION ABOVE & AGREE.
                                    </p>
                                    <div class="border-t border-slate-100 pt-2">
                                        <label
                                            class="mb-1 block text-xs font-semibold text-slate-700"
                                            >Patient / Guardian
                                            Signature:</label
                                        >
                                        <div
                                            v-if="
                                                sidebar.data
                                                    .consent_signatures?.[
                                                    consent.key
                                                ]
                                            "
                                            class="inline-block rounded-lg border border-slate-200 bg-slate-50 p-2"
                                        >
                                            <img
                                                :src="
                                                    sidebar.data
                                                        .consent_signatures[
                                                        consent.key
                                                    ]
                                                "
                                                alt="Consent Signature"
                                                class="h-20 cursor-pointer object-contain"
                                                @click="
                                                    openImageModal(
                                                        sidebar.data
                                                            .consent_signatures[
                                                            consent.key
                                                        ],
                                                    )
                                                "
                                            />
                                        </div>
                                        <span
                                            v-else
                                            class="text-xs italic text-slate-400"
                                            >No signature recorded.</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div
                            class="space-y-2 rounded-lg border border-gray-200 bg-white p-5 shadow-sm"
                        >
                            <h4 class="text-sm font-semibold text-gray-900">
                                Additional Notes
                            </h4>
                            <textarea
                                v-model="sidebar.data.additional_notes"
                                rows="3"
                                class="w-full rounded-md border border-gray-300 p-2 text-sm"
                            ></textarea>
                        </div>

                        <!-- Submit Buttons -->
                        <div
                            class="flex justify-end gap-3 border-t border-gray-200 pt-4"
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
