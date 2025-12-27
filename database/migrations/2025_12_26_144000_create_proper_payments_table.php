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
        // Drop the table if it exists (to handle re-runs cleanly)
        Schema::dropIfExists('payments');

        Schema::create('payments', function (Blueprint $table) {
            // Primary Key
            $table->string('payment_id', 50)->primary();

            // Foreign Keys
            $table->string('customer_id', 50);
            // Assuming customer_id exists in customers table. If migration fails on FK, ensure customers table exists.
            $table->foreign('customer_id')->references('customer_id')->on('customers')->cascadeOnDelete();

            $table->unsignedBigInteger('staff_id')->nullable();
            $table->foreign('staff_id')->references('id')->on('users')->nullOnDelete();

            // Attributes
            $table->decimal('amount', 10, 2);
            $table->string('receipt_path')->nullable();
            $table->enum('verification_status', ['pending', 'verified', 'failed'])->default('pending');
            $table->decimal('penalty', 10, 2)->default(0.00);
            $table->decimal('deposit', 10, 2)->default(0.00);
            
            $table->string('payment')->nullable()->comment('Payment method or reference');
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->decimal('refund_amount', 10, 2)->default(0.00);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
