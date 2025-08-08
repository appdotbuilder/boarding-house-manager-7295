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
        Schema::create('room_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->date('check_in_date')->comment('Date tenant moved in');
            $table->date('check_out_date')->nullable()->comment('Date tenant moved out (null if active)');
            $table->decimal('monthly_rate', 10, 2)->comment('Agreed monthly rate at time of assignment');
            $table->boolean('is_active')->default(true)->comment('Whether this assignment is currently active');
            $table->text('notes')->nullable()->comment('Additional notes about the assignment');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('tenant_id');
            $table->index('room_id');
            $table->index('is_active');
            $table->index(['room_id', 'is_active']);
            $table->index('check_in_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_assignments');
    }
};