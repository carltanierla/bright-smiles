<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_dental_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');

            $table->boolean('significant_injuries')->default(false);
            $table->text('significant_injuries_details')->nullable();

            $table->boolean('thumb_sucking')->default(false);
            $table->text('thumb_sucking_details')->nullable();

            $table->boolean('grind_teeth')->default(false);
            $table->text('grind_teeth_details')->nullable();

            $table->boolean('frequent_blisters')->default(false);
            $table->text('frequent_blisters_details')->nullable();

            $table->boolean('extensive_decay')->default(false);
            $table->text('extensive_decay_details')->nullable();

            $table->boolean('previous_extractions')->default(false);
            $table->text('previous_extractions_details')->nullable();

            $table->boolean('difficulty_swallowing')->default(false);
            $table->text('difficulty_swallowing_details')->nullable();

            $table->boolean('pain_clicking')->default(false);
            $table->text('pain_clicking_details')->nullable();

            $table->boolean('wisdom_teeth')->default(false);
            $table->text('wisdom_teeth_details')->nullable();

            $table->boolean('see_dentist')->default(false);
            $table->date('last_dentist_visit')->nullable();

            $table->boolean('xrays_6_months')->default(false);

            $table->boolean('seen_orthodontist')->default(false);
            $table->text('seen_orthodontist_details')->nullable();

            // Dental specific signature data
            $table->string('signature_path')->nullable();
            $table->date('signature_date')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_dental_histories');
    }
};
