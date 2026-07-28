<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');

            // These columns perfectly match the keys from your Vue 'photoFields' object
            $table->string('frontal')->nullable();
            $table->string('smile')->nullable();
            $table->string('side')->nullable();
            $table->string('teeth_front')->nullable();
            $table->string('teeth_right')->nullable();
            $table->string('teeth_left')->nullable();
            $table->string('teeth_upper')->nullable();
            $table->string('teeth_lower')->nullable();
            $table->string('xray_1')->nullable();
            $table->string('xray_2')->nullable();
            $table->string('referral')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_photos');
    }
};
