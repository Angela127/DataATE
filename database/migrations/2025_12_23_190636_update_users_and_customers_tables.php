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
        // Add avatar to users only if it doesn't exist
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'avatar')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('avatar')->nullable()->after('password');
            });
        }

        // Drop balance from customers only if the column exists
        if (Schema::hasTable('customers') && Schema::hasColumn('customers', 'balance')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->dropColumn('balance');
            });
        }
    }

    /**
     * Reverse the migrations (for php artisan migrate:rollback).
     */
    public function down(): void
    {
        // Only re-add balance if it was removed (won't restore data)
        if (Schema::hasTable('customers') && !Schema::hasColumn('customers', 'balance')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->decimal('balance', 10, 2)->default(0);
            });
        }

        // Only remove avatar if it exists
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'avatar')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('avatar');
            });
        }
    }
};