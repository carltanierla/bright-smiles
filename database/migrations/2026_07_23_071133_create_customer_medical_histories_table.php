<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_medical_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');

            $table->boolean('heart_problems')->default(false);
            $table->text('heart_problems_details')->nullable();

            $table->boolean('blood_pressure')->default(false);
            $table->string('blood_pressure_details')->nullable();

            $table->boolean('excessive_bruising')->default(false);
            $table->text('excessive_bruising_details')->nullable();

            $table->boolean('anaemia')->default(false);
            $table->text('anaemia_details')->nullable();

            $table->boolean('hepatitis')->default(false);
            $table->text('hepatitis_details')->nullable();

            $table->boolean('kidney_disease')->default(false);
            $table->text('kidney_disease_details')->nullable();

            $table->boolean('diabetes')->default(false);
            $table->string('diabetes_type')->nullable();
            $table->string('diabetes_status')->nullable();

            $table->boolean('bone_disorders')->default(false);
            $table->text('bone_disorders_details')->nullable();

            $table->boolean('joint_swelling')->default(false);
            $table->text('joint_swelling_details')->nullable();

            $table->boolean('epilepsy')->default(false);
            $table->text('epilepsy_details')->nullable();

            $table->boolean('thyroid')->default(false);
            $table->string('thyroid_type')->nullable();
            $table->text('thyroid_details')->nullable();

            $table->boolean('tuberculosis')->default(false);
            $table->text('tuberculosis_details')->nullable();

            $table->boolean('anxiety')->default(false);
            $table->text('anxiety_details')->nullable();

            $table->boolean('cancer')->default(false);
            $table->text('cancer_details')->nullable();

            $table->boolean('chemotherapy')->default(false);
            $table->text('chemotherapy_details')->nullable();

            $table->boolean('transplanted_organ')->default(false);
            $table->text('transplanted_organ_details')->nullable();

            $table->boolean('sleep_apnoea')->default(false);
            $table->text('sleep_apnoea_details')->nullable();

            $table->boolean('speech_problems')->default(false);
            $table->string('speech_problems_details')->nullable();

            $table->boolean('tonsils_removed')->default(false);
            $table->text('tonsils_removed_details')->nullable();

            $table->boolean('adenoids_removed')->default(false);
            $table->text('adenoids_removed_details')->nullable();

            $table->boolean('nasal_obstruction')->default(false);
            $table->text('nasal_obstruction_details')->nullable();

            $table->boolean('earaches')->default(false);
            $table->text('earaches_details')->nullable();

            $table->text('allergies')->nullable();
            $table->text('medications')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_medical_histories');
    }
};
