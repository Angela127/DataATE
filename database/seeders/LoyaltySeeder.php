<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Loyalty;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
                // Add other required fields with dummy data if needed by Customer model strictness
                // Based on User provided model, fillable has many fields but maybe nullable in DB?
                // We'll trust the model defaults or nullability for now.
            ]
        );

        // 3. Clear existing loyalty data for this customer
        Loyalty::where('customer_id', $customer->id)->delete();

        // 4. Create History
        
        // Event 1: Earned 1 stamp
        Loyalty::create([
            'customer_id' => $customer->id,
            'type' => 'earned',
            'description' => '1 stamp earned (Booking #1001)',
            'rental_counter' => 1,
            'no_of_stamp' => 1,
            'created_at' => now()->subDays(10),
        ]);

        // Event 2: Earned 1 stamp
        Loyalty::create([
            'customer_id' => $customer->id,
            'type' => 'earned',
            'description' => '1 stamp earned (Booking #1002)',
            'rental_counter' => 2,
            'no_of_stamp' => 2,
            'created_at' => now()->subDays(5),
        ]);

        // Event 3: Earned 1 stamp
        Loyalty::create([
            'customer_id' => $customer->id,
            'type' => 'earned',
            'description' => '1 stamp earned (Booking #1003)',
            'rental_counter' => 3,
            'no_of_stamp' => 3,
            'created_at' => now()->subDays(3),
        ]);

        // Event 4: Redeemed
        Loyalty::create([
            'customer_id' => $customer->id,
            'type' => 'redeemed',
            'description' => 'Voucher Redeemed',
            'rental_counter' => 0, 
            'no_of_stamp' => 3, 
            'created_at' => now()->subDays(2),
        ]);

        // Event 5: Earned 1 stamp (Current State)
        Loyalty::create([
            'customer_id' => $customer->id,
            'type' => 'earned',
            'description' => '1 stamp earned (Booking #1004)',
            'rental_counter' => 1,
            'no_of_stamp' => 4,
            'created_at' => now(),
        ]);
    }
}
