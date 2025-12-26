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
        Schema::table('customers', function (Blueprint $table) {
            $table->enum('documents_status', ['pending', 'approved', 'rejected'])->nullable()->after('matric_staff_image');
            $table->text('documents_rejection_reason')->nullable()->after('documents_status');
            $table->timestamp('documents_submitted_at')->nullable()->after('documents_rejection_reason');
            $table->timestamp('documents_approved_at')->nullable()->after('documents_submitted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['documents_status', 'documents_rejection_reason', 'documents_submitted_at', 'documents_approved_at']);
        });
    }
};
