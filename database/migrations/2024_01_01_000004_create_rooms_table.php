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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boarding_house_id')->constrained('boarding_houses')->onDelete('cascade');
            $table->string('room_number')->comment('Room identifier/number');
            $table->enum('type', ['single', 'double', 'suite', 'dormitory'])->comment('Type of room');
            $table->decimal('price', 10, 2)->comment('Monthly rental price');
            $table->enum('status', ['occupied', 'vacant', 'maintenance'])->default('vacant')->comment('Current room status');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('boarding_house_id');
            $table->index('status');
            $table->index(['boarding_house_id', 'room_number']);
            $table->unique(['boarding_house_id', 'room_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};