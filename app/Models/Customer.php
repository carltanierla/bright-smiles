<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use Notifiable;

    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
//    protected $fillable = [
//        'name',
//        'email',
//        'password',
//        'patient_status',
//        'first_name',
//        'last_name',
//        'sex',
//        'dob',
//        'is_financially_responsible',
//        'familial_status',
//        'mobile_number',
//        'email',
//        'mailing_address_line1',
//        'mailing_address_line2',
//        'mailing_address_suburb',
//        'mailing_address_postcode',
//        'general_dentist',
//        'insurance_company',
//        'insurance_hospital_cover',
//        'insurance_ortho_cover',
//        'primary_party_relationship',
//        'primary_party_first_name',
//        'primary_party_last_name',
//        'primary_party_mobile',
//        'primary_party_secondary_phone',
//        'primary_party_email',
//        'secondary_party_same_as_primary',
//        'secondary_party_release_info',
//        'medical_history',
//        'allergies',
//        'medications',
//        'dental_significant_injuries',
//        'dental_significant_injuries_details',
//        'dental_thumb_sucking',
//        'dental_thumb_sucking_details',
//        'dental_grind_teeth',
//        'dental_grind_teeth_details',
//        'dental_frequent_blisters',
//        'dental_frequent_blisters_details',
//        'dental_extensive_decay',
//        'dental_extensive_decay_details',
//        'dental_previous_extractions',
//        'dental_previous_extractions_details',
//        'dental_difficulty_swallowing',
//        'dental_difficulty_swallowing_details',
//        'dental_pain_clicking',
//        'dental_pain_clicking_details',
//        'dental_wisdom_teeth',
//        'dental_wisdom_teeth_details',
//        'dental_see_dentist',
//        'dental_last_dentist_visit',
//        'dental_xrays_6_months',
//        'dental_seen_orthodontist',
//        'dental_seen_orthodontist_details',
//        'dental_signature_data',
//        'dental_signature_date',
//        'add_photos',
//        'photos_paths',
//        'additional_notes',
//        'consent_financial1_signature',
//        'consent_financial1_date',
//        'consent_informed_signature',
//        'consent_informed_date',
//        'consent_financial2_signature',
//        'consent_financial2_date',
//        'consent_appointment_policy_signature',
//        'consent_appointment_policy_date',
//    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
//    protected function casts(): array
//    {
//        return [
//            'is_financially_responsible' => 'boolean',
//            'secondary_party_same_as_primary' => 'boolean',
//            'secondary_party_release_info' => 'boolean',
//            'medical_history' => 'array',
//            'photos_paths' => 'array',
//            'dental_thumb_sucking' => 'boolean',
//            'dental_grind_teeth' => 'boolean',
//            // ... add the rest of the dental history fields as booleans
//        ];
//    }

    public function photos()
    {
        return $this->hasOne(CustomerPhoto::class);
    }
}
