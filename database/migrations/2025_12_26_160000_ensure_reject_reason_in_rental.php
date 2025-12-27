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
            if (!Schema::hasColumn('rental', 'reject_reason')) {
                $table->text('reject_reason')->nullable()->after('reject_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental', function (Blueprint $table) {
            if (Schema::hasColumn('rental', 'reject_reason')) {
               // We might not want to drop it if it was part of the original schema, 
               // but for this specific fix migration, we can leave it or optionally drop it.
               // $table->dropColumn('reject_reason');
            }
        });
    }
};
