<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->comment('Tenant first name');
            $table->string('last_name')->comment('Tenant last name');
            $table->string('email')->unique()->comment('Tenant email address');
            $table->string('phone')->comment('Contact phone number');
            $table->text('address')->nullable()->comment('Home address');
            $table->date('date_of_birth')->nullable()->comment('Date of birth');
            $table->string('emergency_contact_name')->nullable()->comment('Emergency contact person');
            $table->string('emergency_contact_phone')->nullable()->comment('Emergency contact number');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('email');
            $table->index(['first_name', 'last_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};