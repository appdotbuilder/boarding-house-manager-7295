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
        Schema::create('boarding_houses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Name of the boarding house');
            $table->text('address')->comment('Full address of the boarding house');
            $table->integer('number_of_rooms')->comment('Total number of rooms available');
            $table->string('owner')->comment('Name of the owner');
            $table->string('contact')->comment('Contact number or email');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('name');
            $table->index('owner');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boarding_houses');
    }
};