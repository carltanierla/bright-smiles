<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CustomerControllerwd extends Controller
{
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

            'primaryParty.relationship' => 'nullable|string|max:255',
            'primaryParty.firstName' => 'nullable|string|max:255',
            'primaryParty.lastName' => 'nullable|string|max:255',
            'primaryParty.mobile' => 'nullable|string|max:20',
            'primaryParty.secondaryPhone' => 'nullable|string|max:20',
            'primaryParty.email' => 'nullable|email|max:255',

            'secondaryParty.sameAsPrimary' => 'nullable|string',
            'secondaryParty.releaseInfo' => 'nullable|string',

            'medicalHistory' => 'nullable|array',
            'allergies' => 'nullable|string',
            'medications' => 'nullable|string',

            'dental' => 'nullable|array',
            'dental.lastDentistVisit' => 'nullable|date',
            'dental.signature' => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
            'dental.date' => 'nullable|date',

            'addPhotos' => 'nullable|in:Yes,No',
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'additionalNotes' => 'nullable|string',

            'consents.financialConsent1.signature' => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
            'consents.financialConsent1.date' => 'nullable|date',

            'consents.informedConsent.signature' => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
            'consents.informedConsent.date' => 'nullable|date',

            'consents.financialConsent2.signature' => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
            'consents.financialConsent2.date' => 'nullable|date',

            'consents.appointmentPolicy.signature' => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
            'consents.appointmentPolicy.date' => 'nullable|date',
        ]);

        $toBool = function ($value) {
            return $value === 'Yes';
        };

        DB::beginTransaction();

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

                'primary_party_relationship' => $validated['primaryParty']['relationship'] ?? null,
                'primary_party_first_name' => $validated['primaryParty']['firstName'] ?? null,
                'primary_party_last_name' => $validated['primaryParty']['lastName'] ?? null,
                'primary_party_mobile' => $validated['primaryParty']['mobile'] ?? null,
                'primary_party_secondary_phone' => $validated['primaryParty']['secondaryPhone'] ?? null,
                'primary_party_email' => $validated['primaryParty']['email'] ?? null,

                'secondary_party_same_as_primary' => $toBool($validated['secondaryParty']['sameAsPrimary'] ?? 'Yes'),
                'secondary_party_release_info' => $toBool($validated['secondaryParty']['releaseInfo'] ?? 'No'),

                'add_photos' => $toBool($validated['addPhotos'] ?? 'No'),
                'additional_notes' => $validated['additionalNotes'] ?? null,
            ]);

            // Map and store MEDICAL history
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

            // Map and store DENTAL history
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

                'signature_date' => $dental['date'] ?? null,

                'created_at' => now(),
                'updated_at' => now(),
            ]);

//            $uploadedFiles = [];
//            $photoPaths = [];
//            if ($request->hasFile('photos')) {
//                // $key will equal 'frontal', 'smile', 'side', etc.
//                foreach ($request->file('photos') as $key => $file) {
//                    $extension = $file->getClientOriginalExtension();
//                    $filename = "customer_{$customer->id}_{$key}.{$extension}";
//
//                    $path = $file->storeAs('patient_photos', $filename, 'public');
//                    $photoPaths[$key] = $path;
//                }
//            }
//
//            $dentalSignaturePath = null;
//            if ($request->hasFile('dental.signature')) {
//                $dentalSignaturePath = $request->file('dental.signature')->store('signatures/dental', 'public');
//                $uploadedFiles[] = $dentalSignaturePath;
//            }
//
//            $consentPaths = [];
//            $consentKeys = [
//                'financialConsent1' => 'financial_consent1_path',
//                'informedConsent' => 'informed_consent_path',
//                'financialConsent2' => 'financial_consent2_path',
//                'appointmentPolicy' => 'appointment_policy_path',
//            ];

//            foreach ($consentKeys as $reqKey => $dbKey) {
//                if ($request->hasFile("consents.{$reqKey}.signature")) {
//                    $path = $request->file("consents.{$reqKey}.signature")->store('signatures/consents', 'public');
//                    $consentPaths[$dbKey] = $path;
//                    $uploadedFiles[] = $path;
//                } else {
//                    $consentPaths[$dbKey] = null;
//                }
//            }

//            if (! empty($photoPaths)) {
//                CustomerPhoto::create([
//                    'customer_id' => $customer->id,
//                    'frontal' => $photoPaths['frontal'] ?? null,
//                    'smile' => $photoPaths['smile'] ?? null,
//                    'side' => $photoPaths['side'] ?? null,
//                    'teeth_front' => $photoPaths['teethFront'] ?? null,
//                    'teeth_right' => $photoPaths['teethRight'] ?? null,
//                    'teeth_left' => $photoPaths['teethLeft'] ?? null,
//                    'teeth_upper' => $photoPaths['teethUpper'] ?? null,
//                    'teeth_lower' => $photoPaths['teethLower'] ?? null,
//                    'xray_1' => $photoPaths['xray1'] ?? null,
//                    'xray_2' => $photoPaths['xray2'] ?? null,
//                    'referral' => $photoPaths['referral'] ?? null,
//                ]);
//            }

//            DB::table('customer_consent_forms')->insert([
//                'customer_id' => $customer->id,
//                'financial_consent1_path' => $consentPaths['financial_consent1_path'],
//                'financial_consent1_date' => $validated['consents']['financialConsent1']['date'] ?? null,
//
//                'informed_consent_path' => $consentPaths['informed_consent_path'],
//                'informed_consent_date' => $validated['consents']['informedConsent']['date'] ?? null,
//
//                'financial_consent2_path' => $consentPaths['financial_consent2_path'],
//                'financial_consent2_date' => $validated['consents']['financialConsent2']['date'] ?? null,
//
//                'appointment_policy_path' => $consentPaths['appointment_policy_path'],
//                'appointment_policy_date' => $validated['consents']['appointmentPolicy']['date'] ?? null,
//                'created_at' => now(),
//                'updated_at' => now(),
//            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Application submitted successfully!',
                'customer_id' => $customer->id,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

//            foreach ($photoPaths as $path) {
//                Storage::disk('public')->delete($path);
//            }

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while saving your application.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
