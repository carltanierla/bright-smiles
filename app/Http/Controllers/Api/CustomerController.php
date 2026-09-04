<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    /**
     * Fetch customers with server-side filtering, sorting, and searching.
     */
    public function index(Request $request)
    {
        $query = Customer::with([
            'medicalHistory',
            'dentalHistory',
            'photos',
            'consentForms'
        ]);

        // 1. Search Query
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // 2. Status Filters
        if ($request->filled('status')) {
            $statuses = explode(',', $request->status);
            $query->whereIn('patient_status', $statuses);
        }

        // 3. Sorting
        $sortBy = $request->get('sort_by', 'id');
        $sortDir = $request->get('sort_dir', 'desc');
        $allowedSorts = ['id', 'patient_status', 'first_name', 'last_name', 'sex', 'dob', 'mobile_number', 'email', 'general_dentist'];

        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
        }

        return response()->json($query->get());
    }

    /**
     * Helper to decode and store a base64 image string.
     */
    private function storeBase64($base64String, $folder, $filename)
    {
        if (empty($base64String) || !str_starts_with($base64String, 'data:image')) {
            return null; // Return null if it's already a URL/path or empty
        }

        if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $matches)) {
            $extension = strtolower($matches[1]);
            $base64String = substr($base64String, strpos($base64String, ',') + 1);
        } else {
            $extension = 'png';
        }

        if (! in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            return null;
        }

        $base64String = str_replace(' ', '+', $base64String);
        $decodedData = base64_decode($base64String);

        if ($decodedData === false) {
            return null;
        }

        $filePath = "{$folder}/{$filename}.{$extension}";
        Storage::disk('public')->put($filePath, $decodedData);

        return $filePath;
    }

    /**
     * Store new customer (Your original method)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patientStatus' => 'nullable',
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'sex' => 'required|in:Male,Female',
            'dob' => 'required|date',
            'financiallyResponsible' => 'required|in:Yes,No',
            'familialStatus' => 'nullable|string|max:255',
            'mobileNumber' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',

            'mailingAddress.line1' => 'nullable|string|max:255',
            'mailingAddress.line2' => 'nullable|string|max:255',
            'mailingAddress.suburb' => 'nullable|string|max:255',
            'mailingAddress.postCode' => 'nullable|string|max:20',

            'generalDentist' => 'nullable|string|max:255',

            'insurance.company' => 'nullable|string|max:255',
            'insurance.hospitalCover' => 'nullable|string|max:255',
            'insurance.orthoCover' => 'nullable|string|max:255',

            // Primary Responsible Party Validation
            'primaryParty.relationship' => 'nullable|string|max:255',
            'primaryParty.firstName' => 'nullable|string|max:255',
            'primaryParty.lastName' => 'nullable|string|max:255',
            'primaryParty.mobile' => 'nullable|string|max:20',
            'primaryParty.secondaryPhone' => 'nullable|string|max:20',
            'primaryParty.email' => 'nullable|email|max:255',
            'primaryParty.address.line1' => 'nullable|string|max:255',
            'primaryParty.address.line2' => 'nullable|string|max:255',
            'primaryParty.address.suburb' => 'nullable|string|max:255',
            'primaryParty.address.postCode' => 'nullable|string|max:20',

            // Secondary Responsible Party Validation (All Nullable / Optional)
            'secondaryParty.relationship' => 'nullable|string|max:255',
            'secondaryParty.firstName' => 'nullable|string|max:255',
            'secondaryParty.lastName' => 'nullable|string|max:255',
            'secondaryParty.mobile' => 'nullable|string|max:20',
            'secondaryParty.secondaryPhone' => 'nullable|string|max:20',
            'secondaryParty.email' => 'nullable|email|max:255',
            'secondaryParty.sameAsPrimary' => 'nullable|string',
            'secondaryParty.address.line1' => 'nullable|string|max:255',
            'secondaryParty.address.line2' => 'nullable|string|max:255',
            'secondaryParty.address.suburb' => 'nullable|string|max:255',
            'secondaryParty.address.postCode' => 'nullable|string|max:20',
            'secondaryParty.releaseInfo' => 'nullable|string',

            'medicalHistory' => 'nullable|array',
            'allergies' => 'nullable|string',
            'medications' => 'nullable|string',

            'dental' => 'nullable|array',
            'dental.significantInjuries' => 'nullable|string|in:Yes,No',
            'dental.significantInjuriesDetails' => 'nullable|string',
            'dental.thumbSucking' => 'nullable|string|in:Yes,No',
            'dental.thumbSuckingDetails' => 'nullable|string',
            'dental.grindTeeth' => 'nullable|string|in:Yes,No',
            'dental.grindTeethDetails' => 'nullable|string',
            'dental.frequentBlisters' => 'nullable|string|in:Yes,No',
            'dental.frequentBlistersDetails' => 'nullable|string',
            'dental.extensiveDecay' => 'nullable|string|in:Yes,No',
            'dental.extensiveDecayDetails' => 'nullable|string',
            'dental.previousExtractions' => 'nullable|string|in:Yes,No',
            'dental.previousExtractionsDetails' => 'nullable|string',
            'dental.difficultySwallowing' => 'nullable|string|in:Yes,No',
            'dental.difficultySwallowingDetails' => 'nullable|string',
            'dental.painClicking' => 'nullable|string|in:Yes,No',
            'dental.painClickingDetails' => 'nullable|string',
            'dental.wisdomTeeth' => 'nullable|string|in:Yes,No',
            'dental.wisdomTeethDetails' => 'nullable|string',
            'dental.seeDentist' => 'nullable|string|in:Yes,No',
            'dental.xrays6Months' => 'nullable|string|in:Yes,No',
            'dental.seenOrthodontist' => 'nullable|string|in:Yes,No',
            'dental.seenOrthodontistDetails' => 'nullable|string',
            'dental.lastDentistVisit' => 'nullable|date',
            'dental.signature' => 'nullable|string',
            'dental.date' => 'nullable|date',

            'addPhotos' => 'nullable|in:Yes,No',
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|string',
            'additionalNotes' => 'nullable|string',

            'consents.financialConsent1.signature' => 'nullable|string',
            'consents.financialConsent1.date' => 'nullable|date',
            'consents.informedConsent.signature' => 'nullable|string',
            'consents.informedConsent.date' => 'nullable|date',
            'consents.financialConsent2.signature' => 'nullable|string',
            'consents.financialConsent2.date' => 'nullable|date',
            'consents.appointmentPolicy.signature' => 'nullable|string',
            'consents.appointmentPolicy.date' => 'nullable|date',
        ]);

        $toBool = function ($value) {
            return $value === 'Yes';
        };

        DB::beginTransaction();

        $uploadedFiles = [];

        try {
            $customer = Customer::create([
                'patient_status' => $validated['patientStatus'],
                'first_name' => $validated['firstName'],
                'last_name' => $validated['lastName'],
                'sex' => $validated['sex'],
                'dob' => $validated['dob'],
                'is_financially_responsible' => $toBool($validated['financiallyResponsible'] ?? 'Yes'),
                'familial_status' => $validated['familialStatus'] ?? null,
                'mobile_number' => $validated['mobileNumber'],
                'email' => $validated['email'] ?? null,

                'mailing_address_line1' => $validated['mailingAddress']['line1'] ?? null,
                'mailing_address_line2' => $validated['mailingAddress']['line2'] ?? null,
                'mailing_address_suburb' => $validated['mailingAddress']['suburb'] ?? null,
                'mailing_address_postcode' => $validated['mailingAddress']['postCode'] ?? null,

                'general_dentist' => $validated['generalDentist'] ?? null,

                'insurance_company' => $validated['insurance']['company'] ?? null,
                'insurance_hospital_cover' => $validated['insurance']['hospitalCover'] ?? null,
                'insurance_ortho_cover' => $validated['insurance']['orthoCover'] ?? null,

                // Primary Party Mapping
                'primary_party_relationship' => $validated['primaryParty']['relationship'] ?? null,
                'primary_party_first_name' => $validated['primaryParty']['firstName'] ?? null,
                'primary_party_last_name' => $validated['primaryParty']['lastName'] ?? null,
                'primary_party_mobile' => $validated['primaryParty']['mobile'] ?? null,
                'primary_party_secondary_phone' => $validated['primaryParty']['secondaryPhone'] ?? null,
                'primary_party_email' => $validated['primaryParty']['email'] ?? null,
                'primary_party_address_line1' => $validated['primaryParty']['address']['line1'] ?? null,
                'primary_party_address_line2' => $validated['primaryParty']['address']['line2'] ?? null,
                'primary_party_address_suburb' => $validated['primaryParty']['address']['suburb'] ?? null,
                'primary_party_address_postcode' => $validated['primaryParty']['address']['postCode'] ?? null,

                // Secondary Party Mapping
                'secondary_party_relationship' => $validated['secondaryParty']['relationship'] ?? null,
                'secondary_party_first_name' => $validated['secondaryParty']['firstName'] ?? null,
                'secondary_party_last_name' => $validated['secondaryParty']['lastName'] ?? null,
                'secondary_party_mobile' => $validated['secondaryParty']['mobile'] ?? null,
                'secondary_party_secondary_phone' => $validated['secondaryParty']['secondaryPhone'] ?? null,
                'secondary_party_same_as_primary' => $toBool($validated['secondaryParty']['sameAsPrimary'] ?? 'Yes'),
                'secondary_party_email' => $validated['secondaryParty']['email'] ?? null,
                'secondary_party_address_line1' => $validated['secondaryParty']['address']['line1'] ?? null,
                'secondary_party_address_line2' => $validated['secondaryParty']['address']['line2'] ?? null,
                'secondary_party_address_suburb' => $validated['secondaryParty']['address']['suburb'] ?? null,
                'secondary_party_address_postcode' => $validated['secondaryParty']['address']['postCode'] ?? null,
                'secondary_party_release_info' => $toBool($validated['secondaryParty']['releaseInfo'] ?? 'No'),

                'add_photos' => $toBool($validated['addPhotos'] ?? 'No'),
                'additional_notes' => $validated['additionalNotes'] ?? null,
            ]);

            // Medical History
            $medHistory = $validated['medicalHistory'] ?? [];
            DB::table('customer_medical_histories')->insert([
                'customer_id' => $customer->id,
                'heart_problems' => $medHistory['heartProblems']['checked'] ?? false,
                'heart_problems_details' => $medHistory['heartProblems']['details'] ?? null,
                'blood_pressure' => $medHistory['bloodPressure']['checked'] ?? false,
                'blood_pressure_details' => $medHistory['bloodPressure']['type'] ?? null,
                'excessive_bruising' => $medHistory['excessiveBruising']['checked'] ?? false,
                'excessive_bruising_details' => $medHistory['excessiveBruising']['details'] ?? null,
                'anaemia' => $medHistory['anaemia']['checked'] ?? false,
                'anaemia_details' => $medHistory['anaemia']['details'] ?? null,
                'hepatitis' => $medHistory['hepatitis']['checked'] ?? false,
                'hepatitis_details' => $medHistory['hepatitis']['details'] ?? null,
                'kidney_disease' => $medHistory['kidneyDisease']['checked'] ?? false,
                'kidney_disease_details' => $medHistory['kidneyDisease']['details'] ?? null,
                'diabetes' => $medHistory['diabetes']['checked'] ?? false,
                'diabetes_type' => $medHistory['diabetes']['type'] ?? null,
                'diabetes_status' => $medHistory['diabetes']['status'] ?? null,
                'bone_disorders' => $medHistory['boneDisorders']['checked'] ?? false,
                'bone_disorders_details' => $medHistory['boneDisorders']['details'] ?? null,
                'joint_swelling' => $medHistory['jointSwelling']['checked'] ?? false,
                'joint_swelling_details' => $medHistory['jointSwelling']['details'] ?? null,
                'epilepsy' => $medHistory['epilepsy']['checked'] ?? false,
                'epilepsy_details' => $medHistory['epilepsy']['details'] ?? null,
                'thyroid' => $medHistory['thyroid']['checked'] ?? false,
                'thyroid_type' => $medHistory['thyroid']['type'] ?? null,
                'thyroid_details' => $medHistory['thyroid']['details'] ?? null,
                'tuberculosis' => $medHistory['tuberculosis']['checked'] ?? false,
                'tuberculosis_details' => $medHistory['tuberculosis']['details'] ?? null,
                'anxiety' => $medHistory['anxiety']['checked'] ?? false,
                'anxiety_details' => $medHistory['anxiety']['details'] ?? null,
                'cancer' => $medHistory['cancer']['checked'] ?? false,
                'cancer_details' => $medHistory['cancer']['details'] ?? null,
                'chemotherapy' => $medHistory['chemotherapy']['checked'] ?? false,
                'chemotherapy_details' => $medHistory['chemotherapy']['details'] ?? null,
                'transplanted_organ' => $medHistory['transplantedOrgan']['checked'] ?? false,
                'transplanted_organ_details' => $medHistory['transplantedOrgan']['details'] ?? null,
                'sleep_apnoea' => $medHistory['sleepApnoea']['checked'] ?? false,
                'sleep_apnoea_details' => $medHistory['sleepApnoea']['details'] ?? null,
                'speech_problems' => $medHistory['speechProblems']['checked'] ?? false,
                'speech_problems_details' => $medHistory['speechProblems']['therapyHistory'] ?? null,
                'tonsils_removed' => $medHistory['tonsilsRemoved']['checked'] ?? false,
                'tonsils_removed_details' => $medHistory['tonsilsRemoved']['details'] ?? null,
                'adenoids_removed' => $medHistory['adenoidsRemoved']['checked'] ?? false,
                'adenoids_removed_details' => $medHistory['adenoidsRemoved']['details'] ?? null,
                'nasal_obstruction' => $medHistory['nasalObstruction']['checked'] ?? false,
                'nasal_obstruction_details' => $medHistory['nasalObstruction']['details'] ?? null,
                'earaches' => $medHistory['earaches']['checked'] ?? false,
                'earaches_details' => $medHistory['earaches']['details'] ?? null,
                'allergies' => $validated['allergies'] ?? null,
                'medications' => $validated['medications'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Dental Signature
            $dentalSignaturePath = null;
            if (! empty($validated['dental']['signature'])) {
                $filename = "customer_{$customer->id}_dental_sig_".time();
                $dentalSignaturePath = $this->storeBase64($validated['dental']['signature'], 'signatures/dental', $filename);
                if ($dentalSignaturePath) {
                    $uploadedFiles[] = $dentalSignaturePath;
                }
            }

            // Dental History
            $dental = $validated['dental'] ?? [];
            DB::table('customer_dental_histories')->insert([
                'customer_id' => $customer->id,
                'significant_injuries' => $toBool($dental['significantInjuries'] ?? 'No'),
                'significant_injuries_details' => $dental['significantInjuriesDetails'] ?? null,
                'thumb_sucking' => $toBool($dental['thumbSucking'] ?? 'No'),
                'thumb_sucking_details' => $dental['thumbSuckingDetails'] ?? null,
                'grind_teeth' => $toBool($dental['grindTeeth'] ?? 'No'),
                'grind_teeth_details' => $dental['grindTeethDetails'] ?? null,
                'frequent_blisters' => $toBool($dental['frequentBlisters'] ?? 'No'),
                'frequent_blisters_details' => $dental['frequentBlistersDetails'] ?? null,
                'extensive_decay' => $toBool($dental['extensiveDecay'] ?? 'No'),
                'extensive_decay_details' => $dental['extensiveDecayDetails'] ?? null,
                'previous_extractions' => $toBool($dental['previousExtractions'] ?? 'No'),
                'previous_extractions_details' => $dental['previousExtractionsDetails'] ?? null,
                'difficulty_swallowing' => $toBool($dental['difficultySwallowing'] ?? 'No'),
                'difficulty_swallowing_details' => $dental['difficultySwallowingDetails'] ?? null,
                'pain_clicking' => $toBool($dental['painClicking'] ?? 'No'),
                'pain_clicking_details' => $dental['painClickingDetails'] ?? null,
                'wisdom_teeth' => $toBool($dental['wisdomTeeth'] ?? 'No'),
                'wisdom_teeth_details' => $dental['wisdomTeethDetails'] ?? null,
                'see_dentist' => $toBool($dental['seeDentist'] ?? 'No'),
                'last_dentist_visit' => $dental['lastDentistVisit'] ?? null,
                'xrays_6_months' => $toBool($dental['xrays6Months'] ?? 'No'),
                'seen_orthodontist' => $toBool($dental['seenOrthodontist'] ?? 'No'),
                'seen_orthodontist_details' => $dental['seenOrthodontistDetails'] ?? null,
                'signature_path' => $dentalSignaturePath,
                'signature_date' => $dental['date'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Photos
            $photoPaths = [];
            if (! empty($validated['photos'])) {
                foreach ($validated['photos'] as $key => $base64) {
                    if ($base64) {
                        $filename = "customer_{$customer->id}_{$key}_".Str::random(5);
                        $path = $this->storeBase64($base64, 'patient_photos', $filename);
                        if ($path) {
                            $photoPaths[$key] = $path;
                            $uploadedFiles[] = $path;
                        }
                    }
                }
            }

            // Consents
            $consentPaths = [];
            $consentKeys = [
                'financialConsent1' => 'financial_consent1_path',
                'informedConsent' => 'informed_consent_path',
                'financialConsent2' => 'financial_consent2_path',
                'appointmentPolicy' => 'appointment_policy_path',
            ];

            foreach ($consentKeys as $reqKey => $dbKey) {
                if (! empty($validated['consents'][$reqKey]['signature'])) {
                    $filename = "customer_{$customer->id}_{$reqKey}_sig_".time();
                    $path = $this->storeBase64($validated['consents'][$reqKey]['signature'], 'signatures/consents', $filename);

                    if ($path) {
                        $consentPaths[$dbKey] = $path;
                        $uploadedFiles[] = $path;
                    } else {
                        $consentPaths[$dbKey] = null;
                    }
                } else {
                    $consentPaths[$dbKey] = null;
                }
            }

            if (! empty($photoPaths)) {
                CustomerPhoto::create([
                    'customer_id' => $customer->id,
                    'frontal' => $photoPaths['frontal'] ?? null,
                    'smile' => $photoPaths['smile'] ?? null,
                    'side' => $photoPaths['side'] ?? null,
                    'teeth_front' => $photoPaths['teethFront'] ?? null,
                    'teeth_right' => $photoPaths['teethRight'] ?? null,
                    'teeth_left' => $photoPaths['teethLeft'] ?? null,
                    'teeth_upper' => $photoPaths['teethUpper'] ?? null,
                    'teeth_lower' => $photoPaths['teethLower'] ?? null,
                    'xray_1' => $photoPaths['xray1'] ?? null,
                    'xray_2' => $photoPaths['xray2'] ?? null,
                    'referral' => $photoPaths['referral'] ?? null,
                ]);
            }

            DB::table('customer_consent_forms')->insert([
                'customer_id' => $customer->id,
                'financial_consent1_path' => $consentPaths['financial_consent1_path'],
                'financial_consent1_date' => $validated['consents']['financialConsent1']['date'] ?? null,
                'informed_consent_path' => $consentPaths['informed_consent_path'],
                'informed_consent_date' => $validated['consents']['informedConsent']['date'] ?? null,
                'financial_consent2_path' => $consentPaths['financial_consent2_path'],
                'financial_consent2_date' => $validated['consents']['financialConsent2']['date'] ?? null,
                'appointment_policy_path' => $consentPaths['appointment_policy_path'],
                'appointment_policy_date' => $validated['consents']['appointmentPolicy']['date'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Application submitted successfully!',
                'customer_id' => $customer->id,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            foreach ($uploadedFiles as $path) {
                Storage::disk('public')->delete($path);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while saving your application.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update an entire customer entry from the Sidebar Edit
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $toBool = function ($value) {
            return $value === 'Yes' || $value === true || $value === 1 || $value === '1';
        };

        DB::beginTransaction();

        try {
            // Update main patient details
            $customer->update([
                'patient_status' => $request->input('patient_status', $customer->patient_status),
                'first_name' => $request->input('first_name', $customer->first_name),
                'last_name' => $request->input('last_name', $customer->last_name),
                'sex' => $request->input('sex', $customer->sex),
                'dob' => $request->input('dob', $customer->dob),
                'is_financially_responsible' => $toBool($request->input('financially_responsible')),
                'familial_status' => $request->input('familial_status'),
                'mobile_number' => $request->input('mobile_number'),
                'email' => $request->input('email'),

                'mailing_address_line1' => $request->input('mailing_address.line1'),
                'mailing_address_line2' => $request->input('mailing_address.line2'),
                'mailing_address_suburb' => $request->input('mailing_address.suburb'),
                'mailing_address_postcode' => $request->input('mailing_address.postCode'),

                'general_dentist' => $request->input('general_dentist'),

                'insurance_company' => $request->input('insurance.company'),
                'insurance_hospital_cover' => $request->input('insurance.hospital_cover'),
                'insurance_ortho_cover' => $request->input('insurance.ortho_cover'),

                'primary_party_relationship' => $request->input('primary_party.relationship'),
                'primary_party_first_name' => $request->input('primary_party.first_name'),
                'primary_party_last_name' => $request->input('primary_party.last_name'),
                'primary_party_mobile' => $request->input('primary_party.mobile'),
                'primary_party_secondary_phone' => $request->input('primary_party.secondary_phone'),
                'primary_party_email' => $request->input('primary_party.email'),

                'secondary_party_relationship' => $request->input('secondary_party.relationship'),
                'secondary_party_first_name' => $request->input('secondary_party.first_name'),
                'secondary_party_last_name' => $request->input('secondary_party.last_name'),
                'secondary_party_mobile' => $request->input('secondary_party.mobile'),
                'secondary_party_same_as_primary' => $toBool($request->input('secondary_party.same_as_primary')),
                'secondary_party_release_info' => $toBool($request->input('secondary_party.release_info')),

                'additional_notes' => $request->input('additional_notes'),
            ]);

            // Update Medical History
            if ($request->has('medical_history')) {
                $med = $request->input('medical_history');
                $customer->medicalHistory()->updateOrCreate(
                    ['customer_id' => $customer->id],
                    [
                        'heart_problems' => $med['heartProblems']['checked'] ?? false,
                        'heart_problems_details' => $med['heartProblems']['details'] ?? null,
                        'blood_pressure' => $med['bloodPressure']['checked'] ?? false,
                        'blood_pressure_details' => $med['bloodPressure']['type'] ?? null,
                        'excessive_bruising' => $med['excessiveBruising']['checked'] ?? false,
                        'excessive_bruising_details' => $med['excessiveBruising']['details'] ?? null,
                        'anaemia' => $med['anaemia']['checked'] ?? false,
                        'anaemia_details' => $med['anaemia']['details'] ?? null,
                        'hepatitis' => $med['hepatitis']['checked'] ?? false,
                        'hepatitis_details' => $med['hepatitis']['details'] ?? null,
                        'kidney_disease' => $med['kidneyDisease']['checked'] ?? false,
                        'kidney_disease_details' => $med['kidneyDisease']['details'] ?? null,
                        'diabetes' => $med['diabetes']['checked'] ?? false,
                        'diabetes_type' => $med['diabetes']['type'] ?? null,
                        'diabetes_status' => $med['diabetes']['status'] ?? null,
                        'bone_disorders' => $med['boneDisorders']['checked'] ?? false,
                        'bone_disorders_details' => $med['boneDisorders']['details'] ?? null,
                        'joint_swelling' => $med['jointSwelling']['checked'] ?? false,
                        'joint_swelling_details' => $med['jointSwelling']['details'] ?? null,
                        'epilepsy' => $med['epilepsy']['checked'] ?? false,
                        'epilepsy_details' => $med['epilepsy']['details'] ?? null,
                        'thyroid' => $med['thyroid']['checked'] ?? false,
                        'thyroid_type' => $med['thyroid']['type'] ?? null,
                        'thyroid_details' => $med['thyroid']['details'] ?? null,
                        'tuberculosis' => $med['tuberculosis']['checked'] ?? false,
                        'tuberculosis_details' => $med['tuberculosis']['details'] ?? null,
                        'anxiety' => $med['anxiety']['checked'] ?? false,
                        'anxiety_details' => $med['anxiety']['details'] ?? null,
                        'cancer' => $med['cancer']['checked'] ?? false,
                        'cancer_details' => $med['cancer']['details'] ?? null,
                        'chemotherapy' => $med['chemotherapy']['checked'] ?? false,
                        'chemotherapy_details' => $med['chemotherapy']['details'] ?? null,
                        'transplanted_organ' => $med['transplantedOrgan']['checked'] ?? false,
                        'transplanted_organ_details' => $med['transplantedOrgan']['details'] ?? null,
                        'sleep_apnoea' => $med['sleepApnoea']['checked'] ?? false,
                        'sleep_apnoea_details' => $med['sleepApnoea']['details'] ?? null,
                        'speech_problems' => $med['speechProblems']['checked'] ?? false,
                        'speech_problems_details' => $med['speechProblems']['details'] ?? null,
                        'tonsils_removed' => $med['tonsilsRemoved']['checked'] ?? false,
                        'tonsils_removed_details' => $med['tonsilsRemoved']['details'] ?? null,
                        'adenoids_removed' => $med['adenoidsRemoved']['checked'] ?? false,
                        'adenoids_removed_details' => $med['adenoidsRemoved']['details'] ?? null,
                        'nasal_obstruction' => $med['nasalObstruction']['checked'] ?? false,
                        'nasal_obstruction_details' => $med['nasalObstruction']['details'] ?? null,
                        'earaches' => $med['earaches']['checked'] ?? false,
                        'earaches_details' => $med['earaches']['details'] ?? null,
                        'allergies' => $request->input('allergies'),
                        'medications' => $request->input('medications'),
                    ]
                );
            }

            // Update Dental History
            if ($request->has('dental')) {
                $den = $request->input('dental');
                $customer->dentalHistory()->updateOrCreate(
                    ['customer_id' => $customer->id],
                    [
                        'significant_injuries' => $toBool($den['significantInjuries'] ?? false),
                        'significant_injuries_details' => $den['significantInjuriesDetails'] ?? null,
                        'thumb_sucking' => $toBool($den['thumbSucking'] ?? false),
                        'thumb_sucking_details' => $den['thumbSuckingDetails'] ?? null,
                        'grind_teeth' => $toBool($den['grindTeeth'] ?? false),
                        'grind_teeth_details' => $den['grindTeethDetails'] ?? null,
                        'frequent_blisters' => $toBool($den['frequentBlisters'] ?? false),
                        'frequent_blisters_details' => $den['frequentBlistersDetails'] ?? null,
                        'extensive_decay' => $toBool($den['extensiveDecay'] ?? false),
                        'extensive_decay_details' => $den['extensiveDecayDetails'] ?? null,
                        'previous_extractions' => $toBool($den['previousExtractions'] ?? false),
                        'previous_extractions_details' => $den['previousExtractionsDetails'] ?? null,
                        'difficulty_swallowing' => $toBool($den['difficultySwallowing'] ?? false),
                        'difficulty_swallowing_details' => $den['difficultySwallowingDetails'] ?? null,
                        'pain_clicking' => $toBool($den['painClicking'] ?? false),
                        'pain_clicking_details' => $den['painClickingDetails'] ?? null,
                        'wisdom_teeth' => $toBool($den['wisdomTeeth'] ?? false),
                        'wisdom_teeth_details' => $den['wisdomTeethDetails'] ?? null,
                        'see_dentist' => $toBool($den['seeDentist'] ?? false),
                        'last_dentist_visit' => $den['lastDentistVisit'] ?? null,
                        'xrays_6_months' => $toBool($den['xrays6Months'] ?? false),
                        'seen_orthodontist' => $toBool($den['seenOrthodontist'] ?? false),
                        'seen_orthodontist_details' => $den['seenOrthodontistDetails'] ?? null,
                    ]
                );
            }

            // Optional: Handle saving newly uploaded photos from sidebar (Base64 only)
            if ($request->has('photos')) {
                $photosPayload = $request->input('photos');
                $photoRecord = $customer->photos ?? new CustomerPhoto(['customer_id' => $customer->id]);

                foreach (['frontal', 'smile', 'side', 'teethFront', 'teethRight', 'teethLeft', 'teethUpper', 'teethLower', 'xray1', 'xray2', 'referral'] as $key) {
                    $dbKey = strtolower(preg_replace('/([A-Z])/', '_$1', $key)); // e.g. teethFront to teeth_front
                    if (isset($photosPayload[$key]) && str_starts_with($photosPayload[$key], 'data:image')) {
                        $filename = "customer_{$customer->id}_{$key}_" . Str::random(5);
                        $photoRecord->$dbKey = $this->storeBase64($photosPayload[$key], 'patient_photos', $filename);
                    }
                }
                $photoRecord->save();
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'customer' => $customer->load('medicalHistory', 'dentalHistory', 'photos', 'consentForms')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Quickly update only the status from Context Menus / Actions
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['patient_status' => 'required|string']);
        $customer = Customer::findOrFail($id);
        $customer->update(['patient_status' => $request->patient_status]);

        return response()->json(['status' => 'success', 'message' => 'Status updated']);
    }
}
