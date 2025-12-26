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
        Schema::table('rental', function (Blueprint $table) {
            // Drop columns if they exist
            if (Schema::hasColumn('rental', 'receipt_path')) {
                $table->dropColumn('receipt_path');
            }
            if (Schema::hasColumn('rental', 'verification_status')) {
                $table->dropColumn('verification_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental', function (Blueprint $table) {
            $table->string('receipt_path')->nullable();
            $table->enum('verification_status', ['pending', 'verified', 'failed'])->default('pending');
        });
    }
};
