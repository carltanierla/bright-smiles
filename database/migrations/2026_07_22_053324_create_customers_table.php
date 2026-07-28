<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            // Patient Details
            $table->string('patient_status')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('sex', ['Male', 'Female']);
            $table->date('dob');
            $table->boolean('is_financially_responsible')->default(true);
            $table->string('familial_status')->nullable();
            $table->string('mobile_number');
            $table->string('email')->nullable();
            $table->string('mailing_address_line1')->nullable();
            $table->string('mailing_address_line2')->nullable();
            $table->string('mailing_address_suburb')->nullable();
            $table->string('mailing_address_postcode')->nullable();
            $table->string('general_dentist')->nullable();

            // Insurance Info
            $table->string('insurance_company')->nullable();
            $table->string('insurance_hospital_cover')->nullable();
            $table->string('insurance_ortho_cover')->nullable();

            // Primary Responsible Party
            $table->string('primary_party_relationship')->nullable();
            $table->string('primary_party_first_name')->nullable();
            $table->string('primary_party_last_name')->nullable();
            $table->string('primary_party_mobile')->nullable();
            $table->string('primary_party_secondary_phone')->nullable();
            $table->string('primary_party_email')->nullable();
            $table->string('primary_party_address_line1')->nullable();
            $table->string('primary_party_address_line2')->nullable();
            $table->string('primary_party_address_suburb')->nullable();
            $table->string('primary_party_address_postcode')->nullable();

            // Secondary Responsible Party (Optional)
            $table->string('secondary_party_relationship')->nullable();
            $table->string('secondary_party_first_name')->nullable();
            $table->string('secondary_party_last_name')->nullable();
            $table->string('secondary_party_mobile')->nullable();
            $table->string('secondary_party_secondary_phone')->nullable();
            $table->boolean('secondary_party_same_as_primary')->default(true);
            $table->string('secondary_party_email')->nullable();
            $table->string('secondary_party_address_line1')->nullable();
            $table->string('secondary_party_address_line2')->nullable();
            $table->string('secondary_party_address_suburb')->nullable();
            $table->string('secondary_party_address_postcode')->nullable();
            $table->boolean('secondary_party_release_info')->nullable();

            // Photos & X-Rays
            $table->boolean('add_photos')->default(false);
            $table->text('additional_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
