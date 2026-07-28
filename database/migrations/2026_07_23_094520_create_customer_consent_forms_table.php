<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_consent_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');

            $table->string('financial_consent1_path')->nullable();
            $table->date('financial_consent1_date')->nullable();

            $table->string('informed_consent_path')->nullable();
            $table->date('informed_consent_date')->nullable();

            $table->string('financial_consent2_path')->nullable();
            $table->date('financial_consent2_date')->nullable();

            $table->string('appointment_policy_path')->nullable();
            $table->date('appointment_policy_date')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_consent_forms');
    }
};
