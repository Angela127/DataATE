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
        Schema::create('rental', function (Blueprint $table) {

            // Primary Key
            $table->id(); // rental_id (auto increment)

            // Foreign Keys (store as string as per your design)
            $table->string('customer_id', 50);
            $table->string('plate_no', 10);
            $table->string('payment_id', 50);

            // Rental Time
            $table->dateTime('start_time');
            $table->dateTime('end_time');

            // Location Details
            $table->string('pick_up_location', 255);
            $table->string('return_location', 255);
            $table->string('destination', 255)->nullable();

            // Pickup Condition
            $table->string('car_condition_pickup', 255);
            $table->string('car_description_pickup', 255);

            // Documents
            $table->string('agreement_form', 255);

            // Return Condition
            $table->string('car_condition_return', 255);
            $table->string('car_description_return', 255);

            $table->string('inspection_form', 255);

            // Feedback & Rating
            $table->integer('rating');
            $table->string('return_feedback', 255)->nullable();

            // Status Flags
            $table->boolean('document_signed')->default(false);

            $table->enum('reject_status', ['pending', 'rejected', 'approved'])->nullable();
            $table->text('reject_reason')->nullable();

            $table->enum('verification_status', ['pending', 'verified', 'failed'])->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->nullable();

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.  
     */
    public function down(): void
    {
        Schema::dropIfExists('rental');
    }
};
