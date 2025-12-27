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
            $table->string('car_condition_pickup', 255)->nullable()->change();
            $table->string('car_description_pickup', 255)->nullable()->change();
            $table->string('agreement_form', 255)->nullable()->change();
            $table->string('car_condition_return', 255)->nullable()->change();
            $table->string('car_description_return', 255)->nullable()->change();
            $table->string('inspection_form', 255)->nullable()->change();
            $table->integer('rating')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental', function (Blueprint $table) {
            // Reverting validation is tricky if data exists with nulls, 
            // but for dev environment this is acceptable.
            // We won't strictly revert to NOT NULL here to avoid errors on rollback
            // if null data was inserted.
        });
    }
};
