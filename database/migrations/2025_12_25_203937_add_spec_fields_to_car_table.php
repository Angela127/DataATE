<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::table('car', function (Blueprint $table) {

        $table->year('production_year')->nullable();
        $table->string('engine', 100)->nullable();
        $table->integer('engine_cc')->nullable();
        $table->string('fuel_type', 50)->nullable();
        $table->string('transmission', 50)->nullable();
        $table->string('drive_type', 50)->nullable();

        $table->integer('top_speed')->nullable();
        $table->integer('max_power')->nullable();
        $table->integer('max_torque')->nullable();

        $table->boolean('active_status')->default(true);
    });
    }

    public function down(): void
    {
        Schema::table('car', function (Blueprint $table) {
            $table->dropColumn([
                'production_year',
                'engine',
                'engine_cc',
                'fuel_type',
                'transmission',
                'drive_type',
                'top_speed',
                'max_power',
                'max_torque',
                'active_status',
            ]);

        });
    }
};