<template>
    <Head title="Online Form" />
    <div class="min-h-screen px-10 py-10 sm:px-6 md:px-32 lg:px-64 xl:px-80">
        <transition name="fade-slide" mode="out-in">
            <div
                v-if="isSuccess"
                class="shadow-soft rounded-2xl border-t-8 border-primary bg-white p-10 text-center"
            >
                <div
                    class="bg-primaryLight mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full text-primary"
                >
                    <svg
                        class="h-10 w-10"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        ></path>
                    </svg>
                </div>
                <h2 class="mb-3 text-3xl font-bold text-slate-800">
                    Submission Complete!
                </h2>
                <p class="text-lg text-slate-600">
                    Thank you, {{ formData.firstName }}. Your secure details
                    have been received.
                </p>
                <button
                    @click="resetForm"
                    class="hover:bg-primaryDark mt-8 rounded-lg bg-primary px-6 py-2 font-medium text-white transition-colors"
                >
                    Submit Another Request
                </button>
            </div>

            <div
                v-else
                class="shadow-soft overflow-hidden rounded-2xl border-x border-t-8 border-primary border-x-gray-300 bg-white"
            >
                <div
                    class="flex flex-col justify-between gap-4 border-b border-slate-100 px-8 pt-10 pb-6 md:flex-row md:items-center"
                >
                    <div>
                        <h1
                            class="text-3xl font-bold tracking-tight text-slate-800 uppercase"
                        >
                            Bright Smiles Orthodontics
                        </h1>
                        <p class="mt-1 text-slate-500">Patient Online Form</p>
                    </div>
                </div>

                <div
                    class="flex flex-wrap gap-4 border-b border-slate-200 bg-slate-50 px-8 py-4 text-sm font-medium text-slate-500"
                >
                    <div
                        v-for="(stepName, index) in stepNames"
                        :key="index"
                        class="flex items-center gap-2"
                        :class="{
                            'font-bold text-primary': currentStep === index + 1,
                            'opacity-50': currentStep < index + 1,
                        }"
                    >
                        <span
                            class="flex h-5 w-5 items-center justify-center rounded-full border text-xs"
                            :class="
                                currentStep >= index + 1
                                    ? 'border-primary bg-primary text-white'
                                    : 'border-slate-300'
                            "
                        >
                            {{ currentStep > index + 1 ? '✓' : index + 1 }}
                        </span>
                        {{ stepName }}
                        <span v-if="index < stepNames.length - 1" class="ml-2"
                        >→</span
                        >
                    </div>
                </div>

                <div class="h-1.5 w-full bg-slate-200">
                    <div
                        class="h-1.5 bg-primary transition-all duration-300"
                        :style="{ width: `${(currentStep / 5) * 100}%` }"
                    ></div>
                </div>

                <form @submit.prevent="submitForm" class="p-8">
                    <transition name="fade-slide" mode="out-in">
                        <div v-if="currentStep === 1" key="step1">
                            <div class="mb-10 space-y-8">
                                <div>
                                    <h3
                                        class="mb-6 border-b pb-2 text-xl font-bold text-slate-800"
                                    >
                                        Patient's Details
                                    </h3>

                                    <div
                                        class="mb-5 grid grid-cols-1 gap-5 md:grid-cols-2"
                                    >
                                        <div>
                                            <label
                                                class="mb-1 block text-sm font-semibold text-slate-700"
                                            >Patient Status (Office use
                                                only)</label
                                            >
                                            <input
                                                type="text"
                                                v-model="formData.patientStatus"
                                                class="v-input"
                                                maxlength="255"
                                            />
                                        </div>
                                    </div>

                                    <div
                                        class="mb-5 grid grid-cols-1 gap-5 md:grid-cols-2"
                                    >
                                        <div>
                                            <label
                                                class="mb-1 block text-sm font-semibold text-slate-700"
                                            >First Name (as it appears on
                                                Birth Certificate/Driver's
                                                License)
                                                <span class="text-red-500"
                                                >*</span
                                                ></label
                                            >
                                            <input
                                                type="text"
                                                v-model="formData.firstName"
                                                class="v-input"
                                                :class="{'border-red-500 focus:border-red-500 focus:ring-red-500': errors.firstName}"
                                                maxlength="255"
                                            />
                                            <span v-if="errors.firstName" class="text-xs text-red-500 mt-1 block">{{ errors.firstName }}</span>
                                        </div>
                                        <div>
                                            <label
                                                class="mb-1 block text-sm font-semibold text-slate-700"
                                            >Last Name (as it appears on
                                                Birth Certificate/Driver's
                                                License)
                                                <span class="text-red-500"
                                                >*</span
                                                ></label
                                            >
                                            <input
                                                type="text"
                                                v-model="formData.lastName"
                                                class="v-input"
                                                :class="{'border-red-500 focus:border-red-500 focus:ring-red-500': errors.lastName}"
                                                maxlength="255"
                                            />
                                            <span v-if="errors.lastName" class="text-xs text-red-500 mt-1 block">{{ errors.lastName }}</span>
                                        </div>
                                    </div>

                                    <div
                                        class="mb-5 grid grid-cols-1 gap-5 md:grid-cols-3"
                                    >
                                        <div>
                                            <label
                                                class="mb-2 block text-sm font-semibold text-slate-700"
                                            >Sex
                                                <span class="text-red-500"
                                                >*</span
                                                ></label
                                            >
                                            <div class="flex gap-4">
                                                <label
                                                    class="flex cursor-pointer items-center gap-2"
                                                >
                                                    <input
                                                        type="radio"
                                                        v-model="formData.sex"
                                                        value="Male"
                                                        class="custom-check"
                                                    />
                                                    Male
                                                </label>
                                                <label
                                                    class="flex cursor-pointer items-center gap-2"
                                                >
                                                    <input
                                                        type="radio"
                                                        v-model="formData.sex"
                                                        value="Female"
                                                        class="custom-check"
                                                    />
                                                    Female
                                                </label>
                                            </div>
                                            <span v-if="errors.sex" class="text-xs text-red-500 mt-1 block">{{ errors.sex }}</span>
                                        </div>
                                        <div>
                                            <label
                                                class="mb-1 block text-sm font-semibold text-slate-700"
                                            >Birthdate
                                                <span class="text-red-500"
                                                >*</span
                                                ></label
                                            >
                                            <input
                                                type="date"
                                                v-model="formData.dob"
                                                class="v-input"
                                                :class="{'border-red-500 focus:border-red-500 focus:ring-red-500': errors.dob}"
                                            />
                                            <span v-if="errors.dob" class="text-xs text-red-500 mt-1 block">{{ errors.dob }}</span>
                                        </div>
                                        <div>
                                            <label
                                                class="mb-2 block text-sm font-semibold text-slate-700"
                                            >Patient is Financially
                                                Responsible for the
                                                Account</label
                                            >
                                            <div class="mb-1 flex gap-4">
                                                <label
                                                    class="flex cursor-pointer items-center gap-2"
                                                >
                                                    <input
                                                        type="radio"
                                                        v-model="
                                                            formData.financiallyResponsible
                                                        "
                                                        value="Yes"
                                                        class="custom-check"
                                                    />
                                                    Yes
                                                </label>
                                                <label
                                                    class="flex cursor-pointer items-center gap-2"
                                                >
                                                    <input
                                                        type="radio"
                                                        v-model="
                                                            formData.financiallyResponsible
                                                        "
                                                        value="No"
                                                        class="custom-check"
                                                    />
                                                    No
                                                </label>
                                            </div>
                                            <p
                                                class="text-xs text-slate-500 italic"
                                            >
                                                Note: if the patient is a MINOR,
                                                the financially Responsible
                                                Party/parent Guardian is entered
                                                below.
                                            </p>
                                        </div>
                                    </div>

                                    <div
                                        class="mb-5 grid grid-cols-1 gap-5 md:grid-cols-2"
                                    >
                                        <div>
                                            <label
                                                class="mb-1 block text-sm font-semibold text-slate-700"
                                            >
                                                Patient's Mobile Number (If
                                                applicable)
                                                <span class="text-red-500"
                                                >*</span
                                                >
                                            </label>
                                            <input
                                                type="text"
                                                v-model="formData.mobileNumber"
                                                class="v-input"
                                                :class="{'border-red-500 focus:border-red-500 focus:ring-red-500': errors.mobileNumber}"
                                                placeholder="0400 000 000"
                                                maxlength="20"
                                            />
                                            <span v-if="errors.mobileNumber" class="text-xs text-red-500 mt-1 block">{{ errors.mobileNumber }}</span>
                                        </div>
                                        <div>
                                            <label
                                                class="mb-1 block text-sm font-semibold text-slate-700"
                                            >
                                                Patient's Email (If applicable)
                                            </label>
                                            <input
                                                type="email"
                                                v-model="formData.email"
                                                class="v-input"
                                                :class="{'border-red-500 focus:border-red-500 focus:ring-red-500': errors.email}"
                                                placeholder="patient@email.com"
                                                maxlength="255"
                                            />
                                            <span v-if="errors.email" class="text-xs text-red-500 mt-1 block">{{ errors.email }}</span>
                                        </div>
                                    </div>

                                    <Transition name="fade-slide">
                                        <div
                                            v-if="
                                                formData.financiallyResponsible ===
                                                'Yes'
                                            "
                                            class="mb-5 rounded-lg border border-slate-200 bg-slate-50 p-4"
                                        >
                                            <label
                                                class="mb-2 block text-sm font-semibold text-slate-700"
                                            >Primary Mailing Address
                                                <span class="text-red-500"
                                                >*</span
                                                >
                                            </label>
                                            <input
                                                type="text"
                                                v-model="
                                                    formData.mailingAddress
                                                        .line1
                                                "
                                                class="v-input mb-3"
                                                placeholder="Address Line 1"
                                                maxlength="255"
                                            />
                                            <input
                                                type="text"
                                                v-model="
                                                    formData.mailingAddress
                                                        .line2
                                                "
                                                class="v-input mb-3"
                                                placeholder="Address Line 2"
                                                maxlength="255"
                                            />
                                            <div class="grid grid-cols-2 gap-4">
                                                <input
                                                    type="text"
                                                    v-model="
                                                        formData.mailingAddress
                                                            .suburb
                                                    "
                                                    class="v-input"
                                                    placeholder="Suburb"
                                                    maxlength="255"
                                                />
                                                <input
                                                    type="text"
                                                    v-model="
                                                        formData.mailingAddress
                                                            .postCode
                                                    "
                                                    class="v-input"
                                                    placeholder="Post Code"
                                                    maxlength="20"
                                                />
                                            </div>
                                        </div>
                                    </Transition>

                                    <div class="mb-5">
                                        <label
                                            class="mb-1 block text-sm font-semibold text-slate-700"
                                        >Who do you currently see for your
                                            General Dentist Check up?</label
                                        >
                                        <input
                                            type="text"
                                            v-model="formData.generalDentist"
                                            class="v-input"
                                            placeholder="Dentist Name"
                                            maxlength="255"
                                        />
                                    </div>

                                    <!-- Familial Status (Only when Patient is not financially responsible) -->
                                    <Transition name="fade-slide">
                                        <div
                                            v-if="
                                                formData.financiallyResponsible ===
                                                'No'
                                            "
                                            class="mb-6 space-y-6"
                                        >
                                            <div>
                                                <label
                                                    class="mb-1 block text-sm font-semibold text-slate-700"
                                                >Familial Status
                                                    <span class="text-red-500"
                                                    >*</span
                                                    ></label
                                                >
                                                <select
                                                    v-model="
                                                        formData.familialStatus
                                                    "
                                                    class="v-input bg-white"
                                                >
                                                    <option value="" disabled>
                                                        Select...
                                                    </option>
                                                    <option
                                                        value="Single/Never married"
                                                    >
                                                        2 Parents (ie. Primary &
                                                        Secondary Responsible
                                                        Parties details
                                                        required)
                                                    </option>
                                                    <option
                                                        value="Living with partner"
                                                    >
                                                        Single Parent with Sole
                                                        Custody (ie. Only one
                                                        Responsible Party)
                                                    </option>
                                                    <option value="Married">
                                                        Single Parent with
                                                        Partial Custody (ie.
                                                        Both Primary Responsible
                                                        Party & Secondary
                                                        Responsible Party
                                                        Details Required)
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </Transition>

                                    <!-- Primary Responsible Party Section -->
                                    <Transition name="fade-slide">
                                        <div
                                            v-if="
                                                formData.financiallyResponsible ===
                                                'No'
                                            "
                                            class="mb-6 rounded-xl border border-slate-200 bg-slate-50 p-6"
                                        >
                                            <h4
                                                class="mb-4 border-b pb-2 text-lg font-bold text-slate-800"
                                            >
                                                Primary Responsible Party
                                            </h4>

                                            <div
                                                class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-2"
                                            >
                                                <div>
                                                    <label
                                                        class="mb-1 block text-sm font-semibold text-slate-700"
                                                    >Relationship to
                                                        Patient</label
                                                    >
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            formData
                                                                .primaryParty
                                                                .relationship
                                                        "
                                                        class="v-input bg-white"
                                                        placeholder="e.g. Mother, Father, Guardian"
                                                        maxlength="255"
                                                    />
                                                </div>
                                            </div>

                                            <div
                                                class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-2"
                                            >
                                                <div>
                                                    <label
                                                        class="mb-1 block text-sm font-semibold text-slate-700"
                                                    >First Name
                                                        <span
                                                            class="text-red-500"
                                                        >*</span
                                                        ></label
                                                    >
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            formData
                                                                .primaryParty
                                                                .firstName
                                                        "
                                                        class="v-input bg-white"
                                                        maxlength="255"
                                                    />
                                                </div>
                                                <div>
                                                    <label
                                                        class="mb-1 block text-sm font-semibold text-slate-700"
                                                    >Last Name
                                                        <span
                                                            class="text-red-500"
                                                        >*</span
                                                        ></label
                                                    >
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            formData
                                                                .primaryParty
                                                                .lastName
                                                        "
                                                        class="v-input bg-white"
                                                        maxlength="255"
                                                    />
                                                </div>
                                            </div>

                                            <div
                                                class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-3"
                                            >
                                                <div>
                                                    <label
                                                        class="mb-1 block text-sm font-semibold text-slate-700"
                                                    >Mobile Phone
                                                        <span
                                                            class="text-red-500"
                                                        >*</span
                                                        ></label
                                                    >
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            formData
                                                                .primaryParty
                                                                .mobile
                                                        "
                                                        class="v-input bg-white"
                                                        placeholder="0400 000 000"
                                                        maxlength="20"
                                                    />
                                                </div>
                                                <div>
                                                    <label
                                                        class="mb-1 block text-sm font-semibold text-slate-700"
                                                    >Secondary Phone</label
                                                    >
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            formData
                                                                .primaryParty
                                                                .secondaryPhone
                                                        "
                                                        class="v-input bg-white"
                                                        maxlength="20"
                                                    />
                                                </div>
                                                <div>
                                                    <label
                                                        class="mb-1 block text-sm font-semibold text-slate-700"
                                                    >Email Address
                                                        <span
                                                            class="text-red-500"
                                                        >*</span
                                                        ></label
                                                    >
                                                    <input
                                                        type="email"
                                                        v-model="
                                                            formData
                                                                .primaryParty
                                                                .email
                                                        "
                                                        class="v-input bg-white"
                                                        maxlength="255"
                                                    />
                                                </div>
                                            </div>

                                            <div>
                                                <label
                                                    class="mb-1 block text-sm font-semibold text-slate-700"
                                                >Mailing Address</label
                                                >
                                                <input
                                                    type="text"
                                                    v-model="
                                                        formData.primaryParty
                                                            .address.line1
                                                    "
                                                    class="v-input mb-3 bg-white"
                                                    placeholder="Address Line 1"
                                                    maxlength="255"
                                                />
                                                <input
                                                    type="text"
                                                    v-model="
                                                        formData.primaryParty
                                                            .address.line2
                                                    "
                                                    class="v-input mb-3 bg-white"
                                                    placeholder="Address Line 2"
                                                    maxlength="255"
                                                />
                                                <div
                                                    class="grid grid-cols-2 gap-4"
                                                >
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            formData
                                                                .primaryParty
                                                                .address.suburb
                                                        "
                                                        class="v-input bg-white"
                                                        placeholder="Suburb"
                                                        maxlength="255"
                                                    />
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            formData
                                                                .primaryParty
                                                                .address
                                                                .postCode
                                                        "
                                                        class="v-input bg-white"
                                                        placeholder="Post Code"
                                                        maxlength="20"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </Transition>

                                    <!-- Secondary Responsible Party Section (Always Visible) -->
                                    <div
                                        class="mb-6 rounded-xl border border-slate-200 bg-slate-50 p-6"
                                    >
                                        <div
                                            class="mb-4 flex items-center justify-between border-b pb-2"
                                        >
                                            <h4
                                                class="text-lg font-bold text-slate-800"
                                            >
                                                Secondary Responsible Party
                                            </h4>
                                            <span
                                                class="rounded bg-slate-200 px-2.5 py-0.5 text-xs font-semibold tracking-wide text-slate-600 uppercase"
                                            >
                                                Optional
                                            </span>
                                        </div>

                                        <div
                                            class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-2"
                                        >
                                            <div>
                                                <label
                                                    class="mb-1 block text-sm font-semibold text-slate-700"
                                                >Relationship to
                                                    Patient</label
                                                >
                                                <input
                                                    type="text"
                                                    v-model="
                                                        formData.secondaryParty
                                                            .relationship
                                                    "
                                                    class="v-input bg-white"
                                                    placeholder="e.g. Father, Step-parent"
                                                    maxlength="255"
                                                />
                                            </div>
                                        </div>

                                        <div
                                            class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-2"
                                        >
                                            <div>
                                                <label
                                                    class="mb-1 block text-sm font-semibold text-slate-700"
                                                >First Name</label
                                                >
                                                <input
                                                    type="text"
                                                    v-model="
                                                        formData.secondaryParty
                                                            .firstName
                                                    "
                                                    class="v-input bg-white"
                                                    maxlength="255"
                                                />
                                            </div>
                                            <div>
                                                <label
                                                    class="mb-1 block text-sm font-semibold text-slate-700"
                                                >Last Name</label
                                                >
                                                <input
                                                    type="text"
                                                    v-model="
                                                        formData.secondaryParty
                                                            .lastName
                                                    "
                                                    class="v-input bg-white"
                                                    maxlength="255"
                                                />
                                            </div>
                                        </div>

                                        <div
                                            class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-3"
                                        >
                                            <div>
                                                <label
                                                    class="mb-1 block text-sm font-semibold text-slate-700"
                                                >Mobile Phone</label
                                                >
                                                <input
                                                    type="text"
                                                    v-model="
                                                        formData.secondaryParty
                                                            .mobile
                                                    "
                                                    class="v-input bg-white"
                                                    placeholder="0400 000 000"
                                                    maxlength="20"
                                                />
                                            </div>
                                            <div>
                                                <label
                                                    class="mb-1 block text-sm font-semibold text-slate-700"
                                                >Secondary Phone</label
                                                >
                                                <input
                                                    type="text"
                                                    v-model="
                                                        formData.secondaryParty
                                                            .secondaryPhone
                                                    "
                                                    class="v-input bg-white"
                                                    maxlength="20"
                                                />
                                            </div>
                                            <div>
                                                <label
                                                    class="mb-1 block text-sm font-semibold text-slate-700"
                                                >Email Address</label
                                                >
                                                <input
                                                    type="email"
                                                    v-model="
                                                        formData.secondaryParty
                                                            .email
                                                    "
                                                    class="v-input bg-white"
                                                    maxlength="255"
                                                />
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label
                                                class="mb-2 block text-sm font-semibold text-slate-700"
                                            >Is address same as Primary
                                                Responsible Party?</label
                                            >
                                            <div class="flex gap-4">
                                                <label
                                                    class="flex cursor-pointer items-center gap-2"
                                                >
                                                    <input
                                                        type="radio"
                                                        v-model="
                                                            formData
                                                                .secondaryParty
                                                                .sameAsPrimary
                                                        "
                                                        value="Yes"
                                                        class="custom-check"
                                                    />
                                                    Yes
                                                </label>
                                                <label
                                                    class="flex cursor-pointer items-center gap-2"
                                                >
                                                    <input
                                                        type="radio"
                                                        v-model="
                                                            formData
                                                                .secondaryParty
                                                                .sameAsPrimary
                                                        "
                                                        value="No"
                                                        class="custom-check"
                                                    />
                                                    No
                                                </label>
                                            </div>
                                        </div>

                                        <Transition name="fade-slide">
                                            <div
                                                v-if="
                                                    formData.secondaryParty
                                                        .sameAsPrimary === 'No'
                                                "
                                                class="mb-4"
                                            >
                                                <label
                                                    class="mb-1 block text-sm font-semibold text-slate-700"
                                                >Mailing Address</label
                                                >
                                                <input
                                                    type="text"
                                                    v-model="
                                                        formData.secondaryParty
                                                            .address.line1
                                                    "
                                                    class="v-input mb-3 bg-white"
                                                    placeholder="Address Line 1"
                                                    maxlength="255"
                                                />
                                                <input
                                                    type="text"
                                                    v-model="
                                                        formData.secondaryParty
                                                            .address.line2
                                                    "
                                                    class="v-input mb-3 bg-white"
                                                    placeholder="Address Line 2"
                                                    maxlength="255"
                                                />
                                                <div
                                                    class="grid grid-cols-2 gap-4"
                                                >
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            formData
                                                                .secondaryParty
                                                                .address.suburb
                                                        "
                                                        class="v-input bg-white"
                                                        placeholder="Suburb"
                                                        maxlength="255"
                                                    />
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            formData
                                                                .secondaryParty
                                                                .address
                                                                .postCode
                                                        "
                                                        class="v-input bg-white"
                                                        placeholder="Post Code"
                                                        maxlength="20"
                                                    />
                                                </div>
                                            </div>
                                        </Transition>

                                        <div
                                            class="mt-4 border-t border-slate-200 pt-4"
                                        >
                                            <label
                                                class="flex cursor-pointer items-center gap-2 text-sm font-medium text-slate-700"
                                            >
                                                <input
                                                    type="checkbox"
                                                    v-model="
                                                        formData.secondaryParty
                                                            .releaseInfo
                                                    "
                                                    true-value="Yes"
                                                    false-value="No"
                                                    class="custom-check"
                                                />
                                                I consent to release financial
                                                and dental information to the
                                                Secondary Responsible Party.
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="rounded-xl border border-slate-200 bg-slate-50 p-6"
                                >
                                    <h3
                                        class="mb-1 text-lg font-bold text-slate-800"
                                    >
                                        Health Insurance Information
                                    </h3>
                                    <p
                                        class="mb-4 text-sm font-medium text-slate-500"
                                    >
                                        *Skip this if you do not have Private
                                        Health Cover*
                                    </p>

                                    <div
                                        class="mb-5 grid grid-cols-1 gap-5 md:grid-cols-2"
                                    >
                                        <div>
                                            <label
                                                class="mb-1 block text-sm font-semibold text-slate-700"
                                            >Which Private Insurance Company
                                                are you with?</label
                                            >
                                            <select
                                                v-model="
                                                    formData.insurance.company
                                                "
                                                class="v-input bg-white"
                                            >
                                                <option value="">
                                                    Select...
                                                </option>
                                                <option value="BUPA">
                                                    BUPA
                                                </option>
                                                <option value="NIB">NIB</option>
                                                <option value="HCF">HCF</option>
                                                <option value="Medibank">
                                                    Medibank
                                                </option>
                                                <option value="CBHS">
                                                    CBHS
                                                </option>
                                                <option value="Other">
                                                    Other
                                                </option>
                                            </select>
                                        </div>
                                        <div>
                                            <label
                                                class="mb-2 block text-sm font-semibold text-slate-700"
                                            >Do you have Hospital
                                                Cover?</label
                                            >
                                            <div class="flex gap-4">
                                                <label
                                                    class="flex cursor-pointer items-center gap-2"
                                                >
                                                    <input
                                                        type="radio"
                                                        v-model="
                                                            formData.insurance
                                                                .hospitalCover
                                                        "
                                                        value="Yes"
                                                        class="custom-check"
                                                    />Yes
                                                </label>
                                                <label
                                                    class="flex cursor-pointer items-center gap-2"
                                                >
                                                    <input
                                                        type="radio"
                                                        v-model="
                                                            formData.insurance
                                                                .hospitalCover
                                                        "
                                                        value="No"
                                                        class="custom-check"
                                                    />No
                                                </label>
                                                <label
                                                    class="flex cursor-pointer items-center gap-2"
                                                >
                                                    <input
                                                        type="radio"
                                                        v-model="
                                                            formData.insurance
                                                                .hospitalCover
                                                        "
                                                        value="I don't know"
                                                        class="custom-check"
                                                    />I don't know
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            class="mb-2 block text-sm font-semibold text-slate-700"
                                        >Do you have Orthodontic
                                            Cover?</label
                                        >
                                        <div class="flex flex-col gap-2">
                                            <label
                                                class="flex cursor-pointer items-center gap-2"
                                            >
                                                <input
                                                    type="radio"
                                                    v-model="
                                                        formData.insurance
                                                            .orthoCover
                                                    "
                                                    value="Yes, and it is ACTIVE"
                                                    class="custom-check"
                                                />
                                                Yes, and it is ACTIVE (I have
                                                passed all waiting periods)
                                            </label>
                                            <label
                                                class="flex cursor-pointer items-center gap-2"
                                            >
                                                <input
                                                    type="radio"
                                                    v-model="
                                                        formData.insurance
                                                            .orthoCover
                                                    "
                                                    value="Yes, but it has a waiting period"
                                                    class="custom-check"
                                                />
                                                Yes, but it has a waiting period
                                                / I am not sure
                                            </label>
                                            <label
                                                class="flex cursor-pointer items-center gap-2"
                                            >
                                                <input
                                                    type="radio"
                                                    v-model="
                                                        formData.insurance
                                                            .orthoCover
                                                    "
                                                    value="No / I don't know / I don't have cover"
                                                    class="custom-check"
                                                />
                                                No / I don't know / I don't have
                                                cover
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="flex justify-end border-t border-slate-100 pt-6"
                            >
                                <button
                                    type="button"
                                    @click="nextStep"
                                    class="btn-primary"
                                >
                                    Next
                                </button>
                            </div>
                        </div>

                        <div v-else-if="currentStep === 2" key="step2">
                            <div class="mb-10">
                                <h3
                                    class="mb-4 text-lg font-semibold text-primary"
                                >
                                    Medical History
                                </h3>
                                <p class="mb-6 font-medium text-slate-600">
                                    Please tick if you have EVER had any of the
                                    following:
                                </p>

                                <div class="mb-8 space-y-3">
                                    <div
                                        v-for="condition in medicalConditionsConfig"
                                        :key="condition.id"
                                    >
                                        <label
                                            class="group flex cursor-pointer items-start gap-3"
                                        >
                                            <input
                                                type="checkbox"
                                                v-model="
                                                    formData.medicalHistory[
                                                        condition.id
                                                    ].checked
                                                "
                                                class="custom-check mt-1"
                                            />
                                            <span
                                                class="text-sm font-medium text-slate-700"
                                            >{{ condition.label }}</span
                                            >
                                        </label>

                                        <transition name="fade-slide">
                                            <div
                                                v-if="
                                                    formData.medicalHistory[
                                                        condition.id
                                                    ].checked
                                                "
                                                class="mt-2 mb-5 ml-7 rounded-lg border border-slate-200 bg-slate-50 p-4"
                                            >
                                                <div
                                                    v-if="
                                                        condition.extraType ===
                                                        'text'
                                                    "
                                                >
                                                    <label
                                                        class="mb-1 block text-sm font-semibold text-slate-700"
                                                    >{{
                                                            condition.extraLabel
                                                        }}</label
                                                    >
                                                    <input
                                                        type="text"
                                                        v-model="
                                                            formData
                                                                .medicalHistory[
                                                                condition.id
                                                            ].details
                                                        "
                                                        class="v-input bg-white"
                                                    />
                                                </div>

                                                <div
                                                    v-else-if="
                                                        condition.extraType ===
                                                        'select'
                                                    "
                                                >
                                                    <label
                                                        class="mb-1 block text-sm font-semibold text-slate-700"
                                                    >{{
                                                            condition.extraLabel
                                                        }}</label
                                                    >
                                                    <select
                                                        v-model="
                                                            formData
                                                                .medicalHistory[
                                                                condition.id
                                                            ].type
                                                        "
                                                        class="v-input bg-white"
                                                    >
                                                        <option
                                                            value=""
                                                            disabled
                                                        >
                                                            Select...
                                                        </option>
                                                        <option
                                                            v-for="opt in condition.options"
                                                            :key="opt"
                                                            :value="opt"
                                                        >
                                                            {{ opt }}
                                                        </option>
                                                    </select>

                                                    <transition
                                                        name="fade-slide"
                                                    >
                                                        <div
                                                            v-if="
                                                                formData
                                                                    .medicalHistory[
                                                                    condition.id
                                                                ].type ===
                                                                'Other'
                                                            "
                                                            class="mt-4"
                                                        >
                                                            <label
                                                                class="mb-1 block text-sm font-semibold text-slate-700"
                                                            >Please provide
                                                                more
                                                                details:</label
                                                            >
                                                            <input
                                                                type="text"
                                                                v-model="
                                                                    formData
                                                                        .medicalHistory[
                                                                        condition
                                                                            .id
                                                                    ].details
                                                                "
                                                                class="v-input bg-white"
                                                            />
                                                        </div>
                                                    </transition>
                                                </div>

                                                <div
                                                    v-else-if="
                                                        condition.extraType ===
                                                        'diabetes'
                                                    "
                                                    class="grid grid-cols-1 gap-5 md:grid-cols-2"
                                                >
                                                    <div>
                                                        <label
                                                            class="mb-2 block text-sm font-semibold text-slate-700"
                                                        >Type</label
                                                        >
                                                        <div class="flex gap-4">
                                                            <label
                                                                class="flex cursor-pointer items-center gap-2"
                                                            >
                                                                <input
                                                                    type="radio"
                                                                    v-model="
                                                                        formData
                                                                            .medicalHistory[
                                                                            condition
                                                                                .id
                                                                        ].type
                                                                    "
                                                                    value="Insulin dependent"
                                                                    class="custom-check"
                                                                />
                                                                Insulin
                                                                dependent
                                                            </label>
                                                            <label
                                                                class="flex cursor-pointer items-center gap-2"
                                                            >
                                                                <input
                                                                    type="radio"
                                                                    v-model="
                                                                        formData
                                                                            .medicalHistory[
                                                                            condition
                                                                                .id
                                                                        ].type
                                                                    "
                                                                    value="Non-insulin dependent"
                                                                    class="custom-check"
                                                                />
                                                                Non-insulin
                                                                dependent
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="mb-2 block text-sm font-semibold text-slate-700"
                                                        >Status</label
                                                        >
                                                        <div class="flex gap-4">
                                                            <label
                                                                class="flex cursor-pointer items-center gap-2"
                                                            >
                                                                <input
                                                                    type="radio"
                                                                    v-model="
                                                                        formData
                                                                            .medicalHistory[
                                                                            condition
                                                                                .id
                                                                        ].status
                                                                    "
                                                                    value="Well controlled"
                                                                    class="custom-check"
                                                                />
                                                                Well controlled
                                                            </label>
                                                            <label
                                                                class="flex cursor-pointer items-center gap-2"
                                                            >
                                                                <input
                                                                    type="radio"
                                                                    v-model="
                                                                        formData
                                                                            .medicalHistory[
                                                                            condition
                                                                                .id
                                                                        ].status
                                                                    "
                                                                    value="Uncontrolled"
                                                                    class="custom-check"
                                                                />
                                                                Uncontrolled
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div
                                                    v-else-if="
                                                        condition.extraType ===
                                                        'speech'
                                                    "
                                                >
                                                    <label
                                                        class="mb-2 block text-sm font-semibold text-slate-700"
                                                    >History of Speech
                                                        Therapy</label
                                                    >
                                                    <div
                                                        class="flex flex-wrap gap-4"
                                                    >
                                                        <label
                                                            class="flex cursor-pointer items-center gap-2"
                                                        >
                                                            <input
                                                                type="radio"
                                                                v-model="
                                                                    formData
                                                                        .medicalHistory[
                                                                        condition
                                                                            .id
                                                                    ]
                                                                        .therapyHistory
                                                                "
                                                                value="Yes and it has been successful"
                                                                class="custom-check"
                                                            />
                                                            Yes and it has been
                                                            successful
                                                        </label>
                                                        <label
                                                            class="flex cursor-pointer items-center gap-2"
                                                        >
                                                            <input
                                                                type="radio"
                                                                v-model="
                                                                    formData
                                                                        .medicalHistory[
                                                                        condition
                                                                            .id
                                                                    ]
                                                                        .therapyHistory
                                                                "
                                                                value="Currently attending"
                                                                class="custom-check"
                                                            />
                                                            Currently attending
                                                        </label>
                                                        <label
                                                            class="flex cursor-pointer items-center gap-2"
                                                        >
                                                            <input
                                                                type="radio"
                                                                v-model="
                                                                    formData
                                                                        .medicalHistory[
                                                                        condition
                                                                            .id
                                                                    ]
                                                                        .therapyHistory
                                                                "
                                                                value="I have never been"
                                                                class="custom-check"
                                                            />
                                                            I have never been
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </transition>
                                    </div>
                                </div>

                                <div
                                    class="space-y-4 border-t border-slate-100 pt-6"
                                >
                                    <div>
                                        <label
                                            class="mb-1 block text-sm font-semibold text-slate-700"
                                        >Allergies (please list if
                                            applicable)</label
                                        >
                                        <input
                                            type="text"
                                            v-model="formData.allergies"
                                            class="v-input"
                                        />
                                    </div>
                                    <div>
                                        <label
                                            class="mb-1 block text-sm font-semibold text-slate-700"
                                        >Please list any Drugs or
                                            Medications you are taking...</label
                                        >
                                        <textarea
                                            v-model="formData.medications"
                                            rows="3"
                                            class="v-input resize-y"
                                        ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="flex items-center justify-between border-t border-slate-100 pt-6"
                            >
                                <button
                                    type="button"
                                    @click="prevStep"
                                    class="btn-secondary"
                                >
                                    Back
                                </button>
                                <button
                                    type="button"
                                    @click="nextStep"
                                    class="btn-primary"
                                >
                                    Next
                                </button>
                            </div>
                        </div>

                        <div v-else-if="currentStep === 3" key="step3">
                            <div class="mb-10">
                                <h3
                                    class="mb-4 text-lg font-semibold text-primary uppercase"
                                >
                                    Dental History - Please indicate YES if you
                                    have EVER had any of the following:
                                </h3>

                                <div class="mt-8 space-y-4">
                                    <div
                                        v-for="(
                                            question, key
                                        ) in dentalQuestions"
                                        :key="key"
                                        class="grid min-h-18 grid-cols-1 items-start gap-4 md:grid-cols-2"
                                    >
                                        <div>
                                            <label
                                                class="mb-2 block text-sm font-semibold text-slate-700"
                                            >{{ question.label }}</label
                                            >
                                            <div class="flex gap-4">
                                                <label
                                                    class="flex cursor-pointer items-center gap-2"
                                                >
                                                    <input
                                                        type="radio"
                                                        v-model="
                                                            formData.dental[key]
                                                        "
                                                        value="Yes"
                                                        class="custom-check"
                                                    />
                                                    Yes
                                                </label>
                                                <label
                                                    class="flex cursor-pointer items-center gap-2"
                                                >
                                                    <input
                                                        type="radio"
                                                        v-model="
                                                            formData.dental[key]
                                                        "
                                                        value="No"
                                                        class="custom-check"
                                                    />
                                                    No
                                                </label>
                                            </div>
                                        </div>

                                        <div>
                                            <transition name="fade-slide">
                                                <div
                                                    v-if="
                                                        question.extraType &&
                                                        (formData.dental[
                                                            key
                                                        ] === 'Yes' ||
                                                            question.alwaysShowExtra)
                                                    "
                                                >
                                                    <label
                                                        class="mb-1 block text-sm font-semibold text-slate-700"
                                                    >
                                                        {{
                                                            question.extraLabel
                                                        }}
                                                        <span
                                                            v-if="
                                                                question.extraSubLabel
                                                            "
                                                            class="mt-1 block text-xs font-normal text-slate-500"
                                                        >{{
                                                                question.extraSubLabel
                                                            }}</span
                                                        >
                                                    </label>
                                                    <input
                                                        v-if="
                                                            question.extraType ===
                                                            'text'
                                                        "
                                                        type="text"
                                                        v-model="
                                                            formData.dental[
                                                                key + 'Details'
                                                            ]
                                                        "
                                                        class="v-input"
                                                    />
                                                    <input
                                                        v-else-if="
                                                            question.extraType ===
                                                            'date'
                                                        "
                                                        type="date"
                                                        v-model="
                                                            formData.dental
                                                                .lastDentistVisit
                                                        "
                                                        class="v-input max-w-sm"
                                                    />
                                                </div>
                                            </transition>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="mt-10 grid grid-cols-1 gap-5 rounded-xl border border-slate-200 bg-slate-50 p-6 md:grid-cols-2"
                                >
                                    <div class="grid-cols-5">
                                        <label
                                            class="mb-1 block text-sm font-semibold text-slate-700"
                                        >Signature *</label
                                        >
                                        <div>
                                            <Vue3Signature
                                                ref="signature"
                                                :sigOption="options"
                                                :w="'600px'"
                                                :h="'400px'"
                                            />
                                            <div class="buttons">
                                                <button
                                                    class="rounded-full bg-red-500 px-4 py-2 font-bold text-white hover:bg-red-700"
                                                    @click.prevent="clear"
                                                >
                                                    Clear
                                                </button>
                                                <button
                                                    class="rounded-full bg-yellow-500 px-4 py-2 font-bold text-white hover:bg-yellow-700"
                                                    @click.prevent="undo"
                                                >
                                                    Undo
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="ml-10 grid-cols-1 justify-end self-center"
                                    >
                                        <label
                                            class="mb-1 block text-sm font-semibold text-slate-700"
                                        >Today's date</label
                                        >
                                        <span>{{ today }}</span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="flex items-center justify-between border-t border-slate-100 pt-6"
                            >
                                <button
                                    type="button"
                                    @click="prevStep"
                                    class="btn-secondary"
                                >
                                    Back
                                </button>
                                <button
                                    type="button"
                                    @click="nextStep"
                                    class="btn-primary"
                                >
                                    Next
                                </button>
                            </div>
                        </div>

                        <div v-else-if="currentStep === 4" key="step4">
                            <div class="mb-10">
                                <h3
                                    class="mb-4 text-lg font-semibold text-primary"
                                >
                                    Photos & X-rays
                                </h3>

                                <div class="mb-6">
                                    <label
                                        class="mb-2 block text-sm font-semibold text-slate-700"
                                    >Do you want to add photos, x-rays, or a
                                        referral, and any other paperwork to
                                        your submission for the orthodontist to
                                        review?</label
                                    >
                                    <div class="flex gap-4">
                                        <label
                                            class="flex cursor-pointer items-center gap-2"
                                        >
                                            <input
                                                type="radio"
                                                v-model="formData.addPhotos"
                                                value="Yes"
                                                class="custom-check"
                                            />
                                            Yes
                                        </label>
                                        <label
                                            class="flex cursor-pointer items-center gap-2"
                                        >
                                            <input
                                                type="radio"
                                                v-model="formData.addPhotos"
                                                value="No"
                                                class="custom-check"
                                            />
                                            No
                                        </label>
                                    </div>
                                </div>

                                <transition name="fade-slide">
                                    <div v-if="formData.addPhotos === 'Yes'">
                                        <img
                                            src="/images/form/sample_photo.png"
                                            alt=""
                                            class="w-full"
                                        />
                                        <div
                                            class="mb-6 rounded-lg bg-blue-50 p-4 text-sm font-medium text-blue-800"
                                        >
                                            <strong>Helpful Link:</strong>
                                            <a
                                                href="https://youtu.be/T5B7y9Dk9jI?t=105"
                                                target="_blank"
                                                class="underline"
                                            >Here is a link to a Youtube
                                                video that will help you take
                                                great photos at home!</a
                                            >
                                        </div>

                                        <div
                                            class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3"
                                        >
                                            <div
                                                v-for="(
                                                    label, key
                                                ) in photoFields"
                                                :key="key"
                                                class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-center transition-colors hover:bg-slate-100"
                                            >
                                                <label
                                                    class="mb-3 block h-10 text-sm font-semibold text-slate-700"
                                                >{{ label }}</label
                                                >
                                                <input
                                                    type="file"
                                                    @change="
                                                        handleFileUpload(
                                                            $event.target as HTMLInputElement,
                                                            key,
                                                        )
                                                    "
                                                    class="file:bg-primaryLight block w-full cursor-pointer file:mr-4 file:rounded-full file:border-0 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-primary hover:file:bg-blue-100"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </transition>

                                <div
                                    class="mt-8 border-t border-slate-100 pt-6"
                                >
                                    <label
                                        class="mb-1 block text-sm font-semibold text-slate-700"
                                    >Questions, Give credit to a referrer,
                                        or Add Notes and General Feedback,
                                        etc...</label
                                    >
                                    <p class="mb-2 text-xs text-slate-500">
                                        Feel free to ask any questions or type
                                        any notes to us in this area.
                                    </p>
                                    <textarea
                                        v-model="formData.additionalNotes"
                                        rows="4"
                                        class="v-input resize-y"
                                    ></textarea>
                                </div>
                            </div>
                            <div
                                class="flex items-center justify-between border-t border-slate-100 pt-6"
                            >
                                <button
                                    type="button"
                                    @click="prevStep"
                                    class="btn-secondary"
                                >
                                    Back
                                </button>
                                <button
                                    type="button"
                                    @click="nextStep"
                                    class="btn-primary"
                                >
                                    Next
                                </button>
                            </div>
                        </div>

                        <div v-else-if="currentStep === 5" key="step5">
                            <div class="mb-10 space-y-10">
                                <div
                                    v-for="(consent, index) in consentSections"
                                    :key="index"
                                    class="overflow-hidden rounded-xl border border-slate-200"
                                >
                                    <div
                                        class="border-b border-slate-200 bg-slate-100 px-6 py-4"
                                    >
                                        <h3
                                            class="text-lg font-bold text-slate-800"
                                        >
                                            {{ consent.title }}
                                        </h3>
                                    </div>
                                    <div class="p-6">
                                        <div
                                            class="mb-6 rounded-lg border border-slate-200 bg-slate-50 p-4 pr-2 text-sm text-slate-600"
                                        >
                                            <img
                                                :src="`/images/form/${consent.key}.JPG`"
                                                alt=""
                                                class="w-full"
                                            />
                                        </div>
                                        <p
                                            class="mb-4 text-sm font-bold text-slate-800"
                                        >
                                            I HAVE READ AND UNDERSTOOD THE
                                            INFORMATION ABOVE & AGREE.
                                        </p>
                                        <div class="flex w-1/2 justify-between">
                                            <div class="flex justify-between">
                                                <p>Patient's First Name:</p>
                                                <p>{{ formData.firstName }}</p>
                                            </div>
                                            <div class="flex justify-between">
                                                <p>Patient's Last Name:</p>
                                                <p>{{ formData.lastName }}</p>
                                            </div>
                                        </div>

                                        <div
                                            class="grid grid-cols-1 gap-5 rounded-xl border border-slate-200 bg-slate-50 p-6 md:grid-cols-2"
                                        >
                                            <div class="grid-cols-5">
                                                <label
                                                    class="mb-1 block text-sm font-semibold text-slate-700"
                                                >Patient / Guardian
                                                    Signature (Must be 18 years
                                                    old) *</label
                                                >
                                                <div>
                                                    <Vue3Signature
                                                        :ref="
                                                            (el) =>
                                                                setConsentSigRef(
                                                                    el,
                                                                    consent.key,
                                                                )
                                                        "
                                                        :sigOption="options"
                                                        :w="'600px'"
                                                        :h="'400px'"
                                                    />
                                                    <div class="buttons">
                                                        <button
                                                            type="button"
                                                            class="rounded-full bg-red-500 px-4 py-2 font-bold text-white hover:bg-red-700"
                                                            @click.prevent="
                                                                clearConsentSig(
                                                                    consent.key,
                                                                )
                                                            "
                                                        >
                                                            Clear
                                                        </button>
                                                        <button
                                                            type="button"
                                                            class="rounded-full bg-yellow-500 px-4 py-2 font-bold text-white hover:bg-yellow-700"
                                                            @click.prevent="
                                                                undoConsentSig(
                                                                    consent.key,
                                                                )
                                                            "
                                                        >
                                                            Undo
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="ml-10 grid-cols-1 justify-end self-center"
                                            >
                                                <label
                                                    class="mb-1 block text-sm font-semibold text-slate-700"
                                                >Date signed</label
                                                >
                                                <span>{{ today }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="flex items-center justify-between border-t border-slate-100 pt-6"
                            >
                                <button
                                    type="button"
                                    @click="prevStep"
                                    class="btn-secondary"
                                >
                                    Back
                                </button>
                                <button
                                    type="button"
                                    @click="submitForm"
                                    class="btn-primary flex items-center gap-2"
                                    :disabled="isSubmitting"
                                >
                                    <span v-if="!isSubmitting"
                                    >Submit Application</span
                                    >
                                    <span v-else>Submitting...</span>
                                </button>
                            </div>
                        </div>
                    </transition>
                </form>
            </div>
        </transition>
    </div>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, reactive } from 'vue';
import Vue3Signature from 'vue3-signature';

const signature = ref<InstanceType<typeof Vue3Signature> | null>(null);

const consentSignatures = ref<
    Record<string, InstanceType<typeof Vue3Signature> | null>
>({});

const options = reactive({
    penColor: 'rgb(0, 0, 0)',
    backgroundColor: 'rgb(255, 255, 255)',
});

const errors = ref<Record<string, string>>({});

const clear = () => {
    if (signature.value) {
        signature.value.clear();
    }
    formData.dental.signature = null;
};

const undo = () => {
    if (signature.value) {
        signature.value.undo();
    }
};

const setConsentSigRef = (el: any, key: string) => {
    if (el) {
        consentSignatures.value[key] = el;
    }
};

const clearConsentSig = (key: string) => {
    const sig = consentSignatures.value[key];
    if (sig) {
        sig.clear();
    }
};

const undoConsentSig = (key: string) => {
    const sig = consentSignatures.value[key];
    if (sig) {
        sig.undo();
    }
};

const currentStep = ref(1);
const isSubmitting = ref(false);
const isSuccess = ref(false);

const stepNames = [
    'Patient Details',
    'Medical History',
    'Dental History',
    'Photos & X-rays',
    'Consent Forms',
];

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
        label: 'Does the patient see a General Dentist regularly (eg, at least once a year)?',
        extraType: 'date',
        extraLabel: 'Approximate date of your last visit:',
        alwaysShowExtra: true,
    },
    xrays6Months: {
        label: 'Have there X-rays been taken within the last 6 months?',
    },
    seenOrthodontist: {
        label: 'Has the patient seen an Orthodontist before?',
        extraType: 'text',
        extraLabel: 'Please provide more details:',
        extraSubLabel:
            '(Who, When, Were you happy with the Status or Treatment given?)',
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

const consentSections = [
    { title: 'FINANCIAL CONSENT FORM', key: 'financialConsent1' },
    { title: 'INFORMED CONSENT FORM', key: 'informedConsent' },
    { title: 'FINANCIAL CONSENT', key: 'financialConsent2' },
    { title: 'APPOINTMENT POLICY', key: 'appointmentPolicy' },
];

const today = new Date().toISOString().split('T')[0];

const formData: any = reactive({
    // Step 1
    patientStatus: '',
    firstName: '',
    lastName: '',
    sex: '',
    dob: '',
    financiallyResponsible: 'Yes',
    familialStatus: '',
    mobileNumber: '',
    email: '',
    mailingAddress: { line1: '', line2: '', suburb: '', postCode: '' },
    generalDentist: '',
    insurance: { company: '', hospitalCover: '', orthoCover: '' },
    primaryParty: {
        relationship: '',
        firstName: '',
        lastName: '',
        mobile: '',
        secondaryPhone: '',
        email: '',
        address: { line1: '', line2: '', suburb: '', postCode: '' },
    },
    secondaryParty: {
        relationship: '',
        firstName: '',
        lastName: '',
        mobile: '',
        secondaryPhone: '',
        sameAsPrimary: 'Yes',
        email: '',
        address: { line1: '', line2: '', suburb: '', postCode: '' },
        releaseInfo: 'No',
    },

    // Step 2
    medicalHistory: {
        heartProblems: { checked: false, details: '' },
        bloodPressure: { checked: false, type: '' },
        excessiveBruising: { checked: false, details: '' },
        anaemia: { checked: false, details: '' },
        hepatitis: { checked: false, details: '' },
        kidneyDisease: { checked: false, details: '' },
        diabetes: { checked: false, type: '', status: '' },
        boneDisorders: { checked: false, details: '' },
        jointSwelling: { checked: false, details: '' },
        epilepsy: { checked: false, details: '' },
        thyroid: { checked: false, type: '', details: '' },
        tuberculosis: { checked: false, details: '' },
        anxiety: { checked: false, details: '' },
        cancer: { checked: false, details: '' },
        chemotherapy: { checked: false, details: '' },
        transplantedOrgan: { checked: false, details: '' },
        sleepApnoea: { checked: false, details: '' },
        speechProblems: { checked: false, therapyHistory: '' },
        tonsilsRemoved: { checked: false, details: '' },
        adenoidsRemoved: { checked: false, details: '' },
        nasalObstruction: { checked: false, details: '' },
        earaches: { checked: false, details: '' },
    },
    allergies: '',
    medications: '',

    // Step 3
    dental: {
        significantInjuries: 'No',
        significantInjuriesDetails: '',
        thumbSucking: 'No',
        thumbSuckingDetails: '',
        grindTeeth: 'No',
        grindTeethDetails: '',
        frequentBlisters: 'No',
        frequentBlistersDetails: '',
        extensiveDecay: 'No',
        extensiveDecayDetails: '',
        previousExtractions: 'No',
        previousExtractionsDetails: '',
        difficultySwallowing: 'No',
        difficultySwallowingDetails: '',
        painClicking: 'No',
        painClickingDetails: '',
        wisdomTeeth: 'No',
        wisdomTeethDetails: '',
        seeDentist: 'No',
        lastDentistVisit: '',
        xrays6Months: 'No',
        seenOrthodontist: 'No',
        seenOrthodontistDetails: '',
        signature: null,
        date: today,
    },

    // Step 4
    addPhotos: 'No',
    photos: {},
    additionalNotes: '',

    // Step 5
    consents: {
        financialConsent1: { signature: null, date: today },
        informedConsent: { signature: null, date: today },
        financialConsent2: { signature: null, date: today },
        appointmentPolicy: { signature: null, date: today },
    },
});

const handleFileUpload = (
    event: HTMLInputElement,
    fieldKey: string | number,
) => {
    const file = event.files?.[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            formData.photos[fieldKey] = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    }
};

const validateStep1 = () => {
    errors.value = {};
    let isValid = true;

    if (!formData.firstName || formData.firstName.trim() === '') {
        errors.value.firstName = 'First Name is required.';
        isValid = false;
    } else if (formData.firstName.length > 255) {
        errors.value.firstName = 'Must not exceed 255 characters.';
        isValid = false;
    }

    if (!formData.lastName || formData.lastName.trim() === '') {
        errors.value.lastName = 'Last Name is required.';
        isValid = false;
    } else if (formData.lastName.length > 255) {
        errors.value.lastName = 'Must not exceed 255 characters.';
        isValid = false;
    }

    if (!formData.sex) {
        errors.value.sex = 'Sex is required.';
        isValid = false;
    }

    if (!formData.dob) {
        errors.value.dob = 'Birthdate is required.';
        isValid = false;
    }

    if (!formData.mobileNumber || formData.mobileNumber.trim() === '') {
        errors.value.mobileNumber = 'Mobile Number is required.';
        isValid = false;
    } else if (formData.mobileNumber.length > 20) {
        errors.value.mobileNumber = 'Must not exceed 20 characters.';
        isValid = false;
    }

    if (formData.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
        errors.value.email = 'Must be a valid email address.';
        isValid = false;
    }

    return isValid;
};


const nextStep = () => {
    if (currentStep.value === 1) {
        if (!validateStep1()) {
            return; // Stop here if initial backend required fields are not filled
        }
    }

    if (currentStep.value === 3) {
        if (signature.value && !signature.value.isEmpty()) {
            formData.dental.signature = signature.value.save('image/png');
        }
    }

    if (currentStep.value < 5) {
        currentStep.value++;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
};

const prevStep = () => {
    if (currentStep.value > 1) {
        currentStep.value--;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
};

const submitForm = () => {
    isSubmitting.value = true;
    errors.value = {};

    consentSections.forEach((consent) => {
        const sigRef = consentSignatures.value[consent.key];
        if (sigRef && !sigRef.isEmpty()) {
            formData.consents[consent.key].signature = sigRef.save('image/png');
        } else {
            formData.consents[consent.key].signature = null;
        }
    });

    axios
        .post('/api/submit-form', formData)
        .then(() => {
            isSubmitting.value = false;
            isSuccess.value = true;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        })
        .catch((error) => {
            isSubmitting.value = false;
            console.error('Submission errors:', error.response?.data || error);

            if (error.response && error.response.status === 422) {
                const backendErrors = error.response.data.errors;
                for (const key in backendErrors) {
                    errors.value[key] = backendErrors[key][0];
                }

                alert('Please check the form for required fields or errors.');

                // Return to step 1 if the backend flags any step 1 fields
                const step1Keys = ['firstName', 'lastName', 'sex', 'dob', 'mobileNumber', 'email'];
                if (step1Keys.some(key => errors.value[key])) {
                    currentStep.value = 1;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            } else {
                alert(
                    'An unexpected error occurred while saving your application.',
                );
            }
        });
};

const resetForm = () => {
    currentStep.value = 1;
    isSuccess.value = false;
    errors.value = {};
};
</script>

<style scoped>
.v-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #cbd5e1;
    border-radius: 0.5rem;
    background-color: #ffffff;
    transition: all 0.2s ease;
    outline: none;
}
.v-input:focus {
    border-color: #0ea5e9;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.2);
}

.custom-check {
    accent-color: #0ea5e9;
    width: 1.15rem;
    height: 1.15rem;
    cursor: pointer;
    flex-shrink: 0;
}

.btn-primary {
    background-color: #0ea5e9;
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 0.75rem;
    font-weight: bold;
    box-shadow: 0 4px 6px -1px rgba(14, 165, 233, 0.3);
    transition: all 0.2s;
}
.btn-primary:hover {
    background-color: #0284c7;
    transform: translateY(-1px);
}
.btn-secondary {
    color: #475569;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.2s;
}
.btn-secondary:hover {
    color: #0f172a;
}

.fade-slide-enter-active,
.fade-slide-leave-active {
    transition: all 0.3s ease;
}
.fade-slide-enter-from,
.fade-slide-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
</style>
