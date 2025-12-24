<?php

namespace App\Http\Controllers;

use App\Models\Loyalty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoyaltyController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;
        
        if (!$customer) {
            return redirect()->route('home')->with('error', 'Customer profile not found.');
        }

        $current = $customer->currentLoyalty();
        $history = $customer->loyalties()->latest()->get();

        $rentalCounter = $current ? $current->rental_counter : 0;
        
        // Ensure rental counter doesn't exceed 15 for display logic if capped
        // User said "stamps would be accumulated first(max 15 stamps)"
        
        return view('loyalty.loyalty', compact('rentalCounter', 'history'));
    }

    public function redeem()
    {
        $customer = Auth::user()->customer;
        
        if (!$customer) {
            return redirect()->back()->with('error', 'Customer profile not found.');
        }

        $current = $customer->currentLoyalty();
        $currentStamps = $current ? $current->rental_counter : 0;

        if ($currentStamps < 3) {
            return redirect()->back()->with('error', 'Not enough stamps to redeem.');
        }

        // Logic: Reset counter? User said "if he want to redeem, then the stamp(rental counter) is reset."
        // We will reset it to 0. (Or should we subtract 3? "reset" implies 0).
        // Let's assume reset to 0 as per "reset". 
        // Wait, if they have 15, do they lose all 15?
        // "If he dont want to redeem, the stamps would be accumulated first(max 15 stamps) until he want to redeem the voucher"
        // "if he want to redeem, then the stamp(rental counter) is reset."
        // This usually implies exchanging the accumulated value for a reward. 
        // If I have 15 stamps, and I redeem, I probably get a bigger reward or just one reward?
        // The prompt says "when the customer reach 3 stamps, he can choose... if he want to redeem... is reset."
        // It sounds like a binary "Redeem All for Reward" or "Keep Accumulating".
        // I'll implement RESET to 0.

        Loyalty::create([
            'customer_id' => $customer->id,
            'type' => 'redeemed',
            'description' => 'Voucher Redeemed',
            'rental_counter' => 0, // Reset
            'no_of_stamp' => $current ? $current->no_of_stamp : 0, // Lifetime stamps unchanged? Or should they go down? 
                                          // "no_of_stamp" might be lifetime earned. 
                                          // Let's keep lifetime accumulated counter monotonically increasing or steady, 
                                          // but rental_counter is the "current wallet".
        ]);

        return redirect()->back()->with('success', 'Voucher redeemed successfully!');
    }
}
