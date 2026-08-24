<template>
    <Head title="Payment Details Form" />
    <div class="min-h-screen px-10 py-10 sm:px-6 md:px-32 lg:px-64 xl:px-80">
        <transition name="fade-slide" mode="out-in">
            <!-- Success Screen -->
            <div
                v-if="isSuccess"
                class="shadow-soft border-primary rounded-2xl border-t-8 bg-white p-10 text-center"
            >
                <div
                    class="bg-primaryLight text-primary mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full"
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
                    Thank you. Your payment details have been received.
                </p>
                <button
                    @click="resetForm"
                    class="hover:bg-primaryDark bg-primary mt-8 rounded-lg px-6 py-2 font-medium text-white transition-colors"
                >
                    Submit Another Request
                </button>
            </div>

            <!-- Form Card Wrapper -->
            <div
                v-else
                class="shadow-soft border-primary overflow-hidden rounded-2xl border-x border-t-8 border-x-gray-300 bg-white"
            >
                <!-- Form Header -->
                <div
                    class="flex flex-col justify-between gap-4 border-b border-slate-100 px-8 pb-6 pt-10 md:flex-row md:items-center"
                >
                    <div>
                        <h1
                            class="text-3xl font-bold uppercase tracking-tight text-slate-800"
                        >
                            Bright Smiles Orthodontics
                        </h1>
                        <p class="mt-1 text-slate-500">
                            Credit Card Authorization & Payment Details Form
                        </p>
                    </div>
                </div>

                <!-- Provider Information Banner -->
                <div
                    class="flex flex-wrap items-center gap-x-4 gap-y-2 border-b border-slate-200 bg-slate-50 px-8 py-4 text-xs font-medium text-slate-600"
                >
                    <span><strong>Trading As:</strong> Dr Benjamin TAI</span>
                    <span>•</span>
                    <span><strong>Provider No:</strong> 2662177Y</span>
                    <span>•</span>
                    <span><strong>ABN:</strong> 37 275 203 674</span>
                    <span>•</span>
                    <span
                        >B.D.Sc(UWA), B.Sc.D(Hons)(UWA), D.Clin.Dent(Orth)(UWA),
                        MRACDS(Ortho), M Orth RCS Edinburgh</span
                    >
                </div>

                <form @submit.prevent="submitForm" class="p-8">
                    <div class="mb-8 space-y-8">
                        <!-- Cardholder Details Section -->
                        <div>
                            <h3
                                class="mb-6 border-b pb-2 text-xl font-bold text-slate-800"
                            >
                                Cardholder Details
                            </h3>

                            <div class="mb-5">
                                <label
                                    class="mb-1 block text-sm font-semibold text-slate-700"
                                >
                                    Name on Card
                                    <span class="text-red-500">*</span>
                                </label>
                                <div
                                    class="grid grid-cols-1 gap-5 md:grid-cols-2"
                                >
                                    <div>
                                        <input
                                            type="text"
                                            v-model="formData.nameOnCardFirst"
                                            placeholder="First Name"
                                            class="v-input"
                                            :class="{
                                                'border-red-500 focus:border-red-500 focus:ring-red-500':
                                                    errors.nameOnCardFirst,
                                            }"
                                        />
                                        <span
                                            v-if="errors.nameOnCardFirst"
                                            class="mt-1 block text-xs text-red-500"
                                            >{{ errors.nameOnCardFirst }}</span
                                        >
                                    </div>
                                    <div>
                                        <input
                                            type="text"
                                            v-model="formData.nameOnCardLast"
                                            placeholder="Last Name"
                                            class="v-input"
                                            :class="{
                                                'border-red-500 focus:border-red-500 focus:ring-red-500':
                                                    errors.nameOnCardLast,
                                            }"
                                        />
                                        <span
                                            v-if="errors.nameOnCardLast"
                                            class="mt-1 block text-xs text-red-500"
                                            >{{ errors.nameOnCardLast }}</span
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="mb-5">
                                <label
                                    class="mb-1 block text-sm font-semibold text-slate-700"
                                >
                                    Billing Address
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="space-y-3">
                                    <input
                                        type="text"
                                        v-model="formData.addressLine1"
                                        placeholder="Address Line 1"
                                        class="v-input"
                                        :class="{
                                            'border-red-500 focus:border-red-500 focus:ring-red-500':
                                                errors.addressLine1,
                                        }"
                                    />
                                    <input
                                        type="text"
                                        v-model="formData.addressLine2"
                                        placeholder="Address Line 2"
                                        class="v-input"
                                    />
                                    <div
                                        class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-4"
                                    >
                                        <input
                                            type="text"
                                            v-model="formData.city"
                                            placeholder="City"
                                            class="v-input"
                                            :class="{
                                                'border-red-500 focus:border-red-500 focus:ring-red-500':
                                                    errors.city,
                                            }"
                                        />
                                        <input
                                            type="text"
                                            v-model="formData.state"
                                            placeholder="State / Region"
                                            class="v-input"
                                            :class="{
                                                'border-red-500 focus:border-red-500 focus:ring-red-500':
                                                    errors.state,
                                            }"
                                        />
                                        <input
                                            type="text"
                                            v-model="formData.zipCode"
                                            placeholder="Post / Zip Code"
                                            class="v-input"
                                            :class="{
                                                'border-red-500 focus:border-red-500 focus:ring-red-500':
                                                    errors.zipCode,
                                            }"
                                        />
                                        <select
                                            v-model="formData.country"
                                            class="v-input bg-white"
                                        >
                                            <option value="Australia">
                                                Australia
                                            </option>
                                            <option value="United States">
                                                United States
                                            </option>
                                            <option value="United Kingdom">
                                                United Kingdom
                                            </option>
                                            <option value="New Zealand">
                                                New Zealand
                                            </option>
                                            <option value="Philippines">
                                                Philippines
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="mb-5 grid grid-cols-1 gap-5 md:grid-cols-2"
                            >
                                <div>
                                    <label
                                        class="mb-1 block text-sm font-semibold text-slate-700"
                                    >
                                        Email Address
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        v-model="formData.email"
                                        placeholder="cardholder@email.com"
                                        class="v-input"
                                        :class="{
                                            'border-red-500 focus:border-red-500 focus:ring-red-500':
                                                errors.email,
                                        }"
                                    />
                                    <span
                                        v-if="errors.email"
                                        class="mt-1 block text-xs text-red-500"
                                        >{{ errors.email }}</span
                                    >
                                </div>
                                <div>
                                    <label
                                        class="mb-1 block text-sm font-semibold text-slate-700"
                                    >
                                        Patient's Name
                                    </label>
                                    <input
                                        type="text"
                                        v-model="formData.patientName"
                                        placeholder="Full Name of Patient"
                                        class="v-input"
                                    />
                                    <p
                                        class="mt-1 text-xs italic text-slate-500"
                                    >
                                        This is the name of the patient for whom
                                        this payment/deposit is for.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Payment & Authorization Section Box -->
                        <div
                            class="space-y-6 rounded-xl border border-slate-200 bg-slate-50 p-6"
                        >
                            <h3 class="text-lg font-bold text-slate-800">
                                Payment & Authorization Information
                            </h3>

                            <div>
                                <label
                                    class="mb-2 block text-sm font-semibold text-slate-700"
                                >
                                    I authorize Dr Benjamin Tai t/a Bright
                                    Smiles Orthodontics to charge my credit card
                                    for the amounts below.
                                </label>
                                <div class="flex gap-4">
                                    <label
                                        class="flex cursor-pointer items-center gap-2 text-sm font-medium text-slate-700"
                                    >
                                        <input
                                            type="radio"
                                            v-model="formData.authorizeCharge"
                                            value="Yes"
                                            class="custom-check"
                                        />
                                        Yes
                                    </label>
                                    <label
                                        class="flex cursor-pointer items-center gap-2 text-sm font-medium text-slate-700"
                                    >
                                        <input
                                            type="radio"
                                            v-model="formData.authorizeCharge"
                                            value="No"
                                            class="custom-check"
                                        />
                                        No
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label
                                    class="mb-1 block text-sm font-semibold text-slate-700"
                                >
                                    Payment For
                                    <span class="text-red-500">*</span>
                                </label>
                                <select
                                    v-model="formData.paymentFor"
                                    class="v-input bg-white"
                                    :class="{
                                        'border-red-500 focus:border-red-500 focus:ring-red-500':
                                            errors.paymentFor,
                                    }"
                                >
                                    <option
                                        value="Appointment Deposit (non-refundable) - Deducted from Fees on day of appointment, if it has not been rescheduled - $50.00"
                                    >
                                        Appointment Deposit (non-refundable) -
                                        Deducted from Fees on day of
                                        appointment, if it has not been
                                        rescheduled - $50.00
                                    </option>
                                    <option
                                        value="Upper & Lower retainers - Pick up from clinic - $540.00"
                                    >
                                        Upper & Lower retainers - Pick up from
                                        clinic - $540.00
                                    </option>
                                    <option
                                        value="Upper retainer only - Pick up from clinic - $270.00"
                                    >
                                        Upper retainer only - Pick up from
                                        clinic - $270.00
                                    </option>
                                    <option
                                        value="Lower retainer only - Pick up from clinic - $270.00"
                                    >
                                        Lower retainer only - Pick up from
                                        clinic - $270.00
                                    </option>
                                </select>
                                <span
                                    v-if="errors.paymentFor"
                                    class="mt-1 block text-xs text-red-500"
                                    >{{ errors.paymentFor }}</span
                                >
                            </div>

                            <!-- Signature Card -->
                            <div
                                class="grid grid-cols-1 gap-5 rounded-xl border border-slate-200 bg-slate-50 p-6 md:grid-cols-2"
                            >
                                <div class="grid-cols-5">
                                    <label
                                        class="mb-1 block text-sm font-semibold text-slate-700"
                                    >
                                        Cardholder Signature
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <div>
                                        <Vue3Signature
                                            ref="signature"
                                            :sigOption="options"
                                            :w="'600px'"
                                            :h="'400px'"
                                        />
                                        <div class="buttons mt-2 flex gap-2">
                                            <button
                                                type="button"
                                                class="rounded-full bg-red-500 px-4 py-2 font-bold text-white transition-colors hover:bg-red-700"
                                                @click.prevent="clear"
                                            >
                                                Clear
                                            </button>
                                            <button
                                                type="button"
                                                class="rounded-full bg-yellow-500 px-4 py-2 font-bold text-white transition-colors hover:bg-yellow-700"
                                                @click.prevent="undo"
                                            >
                                                Undo
                                            </button>
                                        </div>
                                        <span
                                            v-if="errors.signature"
                                            class="mt-1 block text-xs text-red-500"
                                            >{{ errors.signature }}</span
                                        >
                                    </div>
                                </div>
                                <div
                                    class="ml-10 grid-cols-1 justify-end self-center"
                                >
                                    <label
                                        class="mb-1 block text-sm font-semibold text-slate-700"
                                    >
                                        Date
                                    </label>
                                    <span class="font-medium text-slate-800">{{
                                        todayFormatted
                                    }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- NEW: Stripe Elements Integration matching screenshot -->
                        <div class="mt-6 border-t border-slate-200 pt-4">
                            <h4 class="mb-3 font-bold text-slate-800">
                                Secure Payment
                            </h4>

                            <div
                                v-if="stripeError"
                                class="mb-4 rounded border border-red-200 bg-red-50 p-3 text-sm text-red-600"
                            >
                                {{ stripeError }}
                            </div>

                            <div
                                class="flex flex-col gap-8 rounded-sm bg-[#f4f5f5] p-6 lg:flex-row"
                            >
                                <!-- Left Column: Card Details -->
                                <div class="flex-1 space-y-3">
                                    <div class="stripe-input-container">
                                        <div id="card-number-element"></div>
                                    </div>

                                    <div class="flex gap-3">
                                        <div
                                            class="stripe-input-container w-1/2"
                                        >
                                            <div id="card-expiry-element"></div>
                                        </div>
                                        <div
                                            class="stripe-input-container w-1/2"
                                        >
                                            <div id="card-cvc-element"></div>
                                        </div>
                                    </div>

                                    <select
                                        v-model="formData.country"
                                        class="h-11 w-full rounded-sm border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-blue-500"
                                    >
                                        <option value="Australia">
                                            Australia
                                        </option>
                                        <option value="United States">
                                            United States
                                        </option>
                                        <option value="United Kingdom">
                                            United Kingdom
                                        </option>
                                        <option value="New Zealand">
                                            New Zealand
                                        </option>
                                        <option value="Philippines">
                                            Philippines
                                        </option>
                                    </select>
                                </div>

                                <!-- Right Column: Summary -->
                                <div
                                    class="flex flex-1 flex-col justify-between text-sm text-black"
                                >
                                    <div
                                        class="mb-4 flex justify-between gap-4 leading-relaxed"
                                    >
                                        <span class="w-4/5 pr-4"
                                            >Payment for –
                                            {{ formattedDescription }}</span
                                        >
                                        <span
                                            class="w-1/5 text-right font-medium"
                                            >${{ subtotal.toFixed(2) }}</span
                                        >
                                    </div>

                                    <div
                                        class="space-y-2 border-t border-gray-300 pt-3"
                                    >
                                        <div
                                            class="flex justify-end gap-6 font-bold"
                                        >
                                            <span>Subtotal:</span>
                                            <span class="w-16 text-right"
                                                >${{
                                                    subtotal.toFixed(2)
                                                }}</span
                                            >
                                        </div>
                                        <div class="flex justify-end gap-6">
                                            <span>Stripe Processing Fee:</span>
                                            <span class="w-16 text-right"
                                                >${{
                                                    processingFee.toFixed(2)
                                                }}</span
                                            >
                                        </div>
                                        <div
                                            class="mt-2 flex justify-end gap-6 text-base font-bold"
                                        >
                                            <span>Amount Due:</span>
                                            <span class="w-16 text-right"
                                                >${{
                                                    totalDue.toFixed(2)
                                                }}</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Submission -->
                    <div
                        class="flex justify-end border-t border-slate-100 pt-6"
                    >
                        <button
                            type="submit"
                            class="btn-primary flex items-center gap-2"
                            :disabled="isSubmitting"
                        >
                            <span v-if="!isSubmitting">Submit Form</span>
                            <span v-else>Processing...</span>
                        </button>
                    </div>
                </form>
            </div>
        </transition>
    </div>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import type {
    Stripe,
    StripeElements,
    StripeCardNumberElement} from '@stripe/stripe-js';
import {
    loadStripe
} from '@stripe/stripe-js';
import axios from 'axios';
import { ref, reactive, computed, onMounted } from 'vue';
import Vue3Signature from 'vue3-signature';

const isSubmitting = ref(false);
const isSuccess = ref(false);
const errors = ref<Record<string, string>>({});
const stripeError = ref('');

// Initialize today's date formatted as DD/MM/YYYY
const dateObj = new Date();
const todayFormatted = `${String(dateObj.getDate()).padStart(2, '0')}/${String(dateObj.getMonth() + 1).padStart(2, '0')}/${dateObj.getFullYear()}`;

const signature = ref<InstanceType<typeof Vue3Signature> | null>(null);

const options = reactive({
    penColor: 'rgb(0, 0, 0)',
    backgroundColor: 'rgb(255, 255, 255)',
});

const formData = reactive({
    nameOnCardFirst: '',
    nameOnCardLast: '',
    addressLine1: '',
    addressLine2: '',
    city: '',
    state: '',
    zipCode: '',
    country: 'Australia',
    email: '',
    authorizeCharge: 'No',
    paymentFor:
        'Appointment Deposit (non-refundable) - Deducted from Fees on day of appointment, if it has not been rescheduled - $50.00',
    signature: null as string | null,
    date: todayFormatted,
    patientName: '',
});

// --- STRIPE SETUP & MOUNTING ---
let stripe: Stripe | null = null;
let elements: StripeElements | null = null;
let cardNumber: StripeCardNumberElement | null = null;

const stripePublicKey = 'pk_test_YOUR_STRIPE_PUBLIC_KEY';

onMounted(async () => {
    stripe = await loadStripe(stripePublicKey);

    if (stripe) {
        elements = stripe.elements();

        const style = {
            base: {
                color: '#000000',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '14px',
                '::placeholder': {
                    color: '#aab7c4',
                },
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a',
            },
        };

        cardNumber = elements.create('cardNumber', { style, showIcon: true });
        cardNumber.mount('#card-number-element');

        const cardExpiry = elements.create('cardExpiry', { style });
        cardExpiry.mount('#card-expiry-element');

        const cardCvc = elements.create('cardCvc', { style });
        cardCvc.mount('#card-cvc-element');
    }
});

// --- DYNAMIC PRICING LOGIC ---
const formattedDescription = computed(() => {
    return formData.paymentFor.split(' - $')[0];
});

const subtotal = computed(() => {
    const match = formData.paymentFor.match(/\$([\d,]+\.\d{2})/);

    return match ? parseFloat(match[1].replace(',', '')) : 0;
});

const processingFee = computed(() => {
    return subtotal.value * 0.0424;
});

const totalDue = computed(() => {
    return subtotal.value + processingFee.value;
});

// Helper to get 2-letter ISO Country Code for Stripe
const getCountryCode = (countryName: string) => {
    const map: Record<string, string> = {
        Australia: 'AU',
        'United States': 'US',
        'United Kingdom': 'GB',
        'New Zealand': 'NZ',
        Philippines: 'PH',
    };

    return map[countryName] || 'AU';
};

// --- SIGNATURE METHODS ---
const clear = () => {
    if (signature.value) {
        signature.value.clear();
    }

    formData.signature = null;
};

const undo = () => {
    if (signature.value) {
        signature.value.undo();
    }
};

const validateForm = () => {
    errors.value = {};
    stripeError.value = '';
    let isValid = true;

    if (!formData.nameOnCardFirst.trim()) {
        errors.value.nameOnCardFirst = 'First Name is required.';
        isValid = false;
    }

    if (!formData.nameOnCardLast.trim()) {
        errors.value.nameOnCardLast = 'Last Name is required.';
        isValid = false;
    }

    if (!formData.addressLine1.trim()) {
        errors.value.addressLine1 = 'Address Line 1 is required.';
        isValid = false;
    }

    if (!formData.city.trim()) {
        errors.value.city = 'City is required.';
        isValid = false;
    }

    if (!formData.state.trim()) {
        errors.value.state = 'State is required.';
        isValid = false;
    }

    if (!formData.zipCode.trim()) {
        errors.value.zipCode = 'Zip Code is required.';
        isValid = false;
    }

    if (!formData.email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
        errors.value.email = 'A valid email address is required.';
        isValid = false;
    }

    if (!formData.paymentFor) {
        errors.value.paymentFor = 'Payment option is required.';
        isValid = false;
    }

    if (!signature.value || signature.value.isEmpty()) {
        errors.value.signature = 'Signature is required.';
        isValid = false;
    }

    return isValid;
};

const submitForm = async () => {
    if (!validateForm()) {
        window.scrollTo({ top: 0, behavior: 'smooth' });

        return;
    }

    isSubmitting.value = true;

    if (signature.value && !signature.value.isEmpty()) {
        formData.signature = signature.value.save('image/png');
    }

    if (!stripe || !cardNumber) {
        stripeError.value = 'Stripe is not properly initialized.';
        isSubmitting.value = false;

        return;
    }

    try {
        // Tokenize Card with Stripe using full billing details
        const { error, paymentMethod } = await stripe.createPaymentMethod({
            type: 'card',
            card: cardNumber,
            billing_details: {
                email: formData.email,
                name: `${formData.nameOnCardFirst} ${formData.nameOnCardLast}`,
                address: {
                    line1: formData.addressLine1,
                    line2: formData.addressLine2,
                    city: formData.city,
                    state: formData.state,
                    postal_code: formData.zipCode,
                    country: getCountryCode(formData.country),
                },
            },
        });

        if (error) {
            stripeError.value =
                error.message || 'An error occurred with your payment method.';
            isSubmitting.value = false;

            return;
        }

        // Add calculated stripe properties to original payload
        const payload = {
            ...formData,
            stripePaymentMethodId: paymentMethod.id,
            amount: totalDue.value,
        };

        await axios.post('/api/submit-payment-details', payload);

        isSubmitting.value = false;
        isSuccess.value = true;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    } catch (err: any) {
        isSubmitting.value = false;

        if (err.response && err.response.status === 422) {
            const backendErrors = err.response.data.errors;

            for (const key in backendErrors) {
                errors.value[key] = backendErrors[key][0];
            }

            alert('Please check the form for required fields or errors.');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            stripeError.value =
                'An unexpected error occurred while processing your details.';
        }
    }
};

const resetForm = () => {
    isSuccess.value = false;
    errors.value = {};
    stripeError.value = '';

    Object.keys(formData).forEach((key) => {
        if (key === 'country') {
(formData as any)[key] = 'Australia';
} else if (key === 'authorizeCharge') {
(formData as any)[key] = 'No';
} else if (key === 'paymentFor') {
(formData as any)[key] =
                'Appointment Deposit (non-refundable) - Deducted from Fees on day of appointment, if it has not been rescheduled - $50.00';
} else if (key === 'date') {
(formData as any)[key] = todayFormatted;
} else {
(formData as any)[key] = '';
}
    });

    if (cardNumber) {
cardNumber.clear();
}

    clear();
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

/* Specific styling to make Stripe wrapper divs look like native inputs */
.stripe-input-container {
    background-color: #ffffff;
    border: 1px solid #d1d5db;
    border-radius: 0.125rem;
    padding: 0.65rem 0.75rem;
    height: 44px; /* Matches standard input height */
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.stripe-input-container:focus-within {
    border-color: #0ea5e9;
    outline: 1px solid #0ea5e9;
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
