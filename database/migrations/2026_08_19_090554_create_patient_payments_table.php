<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_payments', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name')->nullable(); // Optional field
            $table->string('name_on_card_first');
            $table->string('name_on_card_last');
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('country');
            $table->string('email');
            $table->string('authorize_charge')->default('No');
            $table->text('payment_for');
            $table->decimal('amount', 8, 2);
            $table->string('stripe_payment_id')->nullable();
            $table->string('payment_status')->default('pending');
            $table->string('date_submitted');
            $table->text('signature_path')->nullable(); // Path to stored image
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_payments');
    }
};
