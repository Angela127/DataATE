<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rental', function (Blueprint $table) {
            // Pickup Location
            $table->decimal('pickup_lat', 10, 7)->nullable();
            $table->decimal('pickup_lng', 10, 7)->nullable();

            // Destination
            $table->decimal('destination_lat', 10, 7)->nullable();
            $table->decimal('destination_lng', 10, 7)->nullable();

            // Return Location
            $table->decimal('return_lat', 10, 7)->nullable();
            $table->decimal('return_lng', 10, 7)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('rental', function (Blueprint $table) {
            $table->dropColumn([
                'pickup_lat', 'pickup_lng',
                'destination_lat', 'destination_lng',
                'return_lat', 'return_lng'
            ]);
        });
    }
};
