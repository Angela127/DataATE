<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Loyalty;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class LoyaltySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure we have a user
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Ensure the user has a customer profile
        $customer = Customer::firstOrCreate(
            ['user_id' => $user->id],
            [
                'username' => 'testuser',
                'phone' => '0123456789',
            ]
        );

        // 3. Clear existing loyalty data for this customer
        Loyalty::where('customer_id', $customer->id)->delete();

        // 4. Create 15 Stamps Loop
        $startDate = now()->subDays(20);
        $totalStamps = 15;

        for ($i = 1; $i <= $totalStamps; $i++) {
            Loyalty::create([
                'customer_id' => $customer->id,
                'type' => 'earned',
                'description' => "1 stamp earned (Seeded Booking #{$i})",
                'rental_counter' => $i,
                // Assuming no_of_stamp tracks lifetime accumulation
                'no_of_stamp' => $i, 
                // Spread dates out over the last 20 days
                'created_at' => $startDate->copy()->addDays($i),
            ]);
        }
    }
}
