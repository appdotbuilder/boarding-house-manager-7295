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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_assignment_id')->constrained('room_assignments')->onDelete('cascade');
            $table->string('invoice_number')->unique()->comment('Unique invoice number');
            $table->date('billing_period_start')->comment('Start date of billing period');
            $table->date('billing_period_end')->comment('End date of billing period');
            $table->decimal('amount', 10, 2)->comment('Total bill amount');
            $table->decimal('utilities', 10, 2)->default(0)->comment('Utilities charges');
            $table->decimal('other_charges', 10, 2)->default(0)->comment('Other miscellaneous charges');
            $table->date('due_date')->comment('Payment due date');
            $table->enum('status', ['pending', 'paid', 'overdue', 'cancelled'])->default('pending')->comment('Payment status');
            $table->date('payment_date')->nullable()->comment('Date payment was received');
            $table->enum('payment_method', ['cash', 'bank_transfer', 'check', 'online'])->nullable()->comment('Method of payment');
            $table->text('notes')->nullable()->comment('Additional notes about the bill');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('room_assignment_id');
            $table->index('invoice_number');
            $table->index('status');
            $table->index('due_date');
            $table->index('billing_period_start');
            $table->index(['status', 'due_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};