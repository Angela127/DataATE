<?php

namespace App\Http\Controllers;

use App\Models\Loyalty;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VoucherController extends Controller
{
    // My Vouchers Page (Profile)
    public function index()
    {
        $customer = Auth::user()->customer;
        
        if (!$customer) {
            return redirect()->route('mainpage');
        }

        $activeVouchers = $customer->vouchers()->active()->latest()->get();
        $pastVouchers = $customer->vouchers()->past()->latest()->get();

        return view('profile.vouchers', compact('activeVouchers', 'pastVouchers'));
    }

    // Redemption Selection Page (Loyalty)
    public function redeemPage()
    {
        $customer = Auth::user()->customer;
        if (!$customer) {
            return redirect()->route('home');
        }

        $currentLoyalty = $customer->currentLoyalty();
        $stamps = $currentLoyalty ? $currentLoyalty->rental_counter : 0;
        $tiers = Loyalty::getRewardTiers();

        return view('loyalty.redeem', compact('stamps', 'tiers'));
    }

    // Process Redemption
    public function store(Request $request)
    {
        $request->validate([
            'tier' => 'required|integer|in:3,6,9,12,15',
        ]);

        $tierCost = $request->tier;
        $customer = Auth::user()->customer;
        $currentLoyalty = $customer->currentLoyalty();
        $currentStamps = $currentLoyalty ? $currentLoyalty->rental_counter : 0;

        if ($currentStamps < $tierCost) {
            return redirect()->back()->with('error', 'Not enough stamps for this reward.');
        }

        // Determine Reward from Dynamic Rules
        $tiers = Loyalty::getRewardTiers();
        
        if (!isset($tiers[$tierCost])) {
             return redirect()->back()->with('error', 'Invalid reward tier.');
        }
        
        $rule = $tiers[$tierCost];
        $discount = $rule['type'] === 'discount' ? $rule['amount'] : null;
        $freeHours = $rule['type'] === 'free_hours' ? $rule['amount'] : null;

        // Auto-generate Description
        $desc = "Reward Voucher";
        if ($discount) {
            if ($discount <= 10) $desc = "Bronze Saver - Enjoy {$discount}% off your next ride.";
            elseif ($discount <= 15) $desc = "Silver Spark - {$discount}% discount for loyal travelers.";
            elseif ($discount <= 20) $desc = "Gold Glider - {$discount}% off to smooth your journey.";
            else $desc = "Platinum Prestige - {$discount}% discount, our premium thanks.";
        } elseif ($freeHours) {
             $desc = "Diamond Day - {$freeHours} Hours of free rental time.";
        }

        // 1. Create Voucher
        Voucher::create([
            'customer_id' => $customer->id,
            'voucher_code' => strtoupper(Str::random(8)),
            'description' => $desc,
            'discount_percent' => $discount,
            'free_hours' => $freeHours,
            'expiry_date' => now()->addDays(30), // Valid for 30 days default
            'status' => 'active',
        ]);

        // 2. Deduct Stamps (Logic: Spend stamps, keep remainder)
        $newCounter = $currentStamps - $tierCost;

        Loyalty::create([
            'customer_id' => $customer->id,
            'type' => 'redeemed',
            'description' => "Redeemed {$tierCost} stamps for " . ($discount ? "{$discount}% Off" : "{$freeHours}H Free"),
            'rental_counter' => $newCounter,
            'no_of_stamp' => $currentLoyalty->no_of_stamp, // Lifetime stays same
        ]);

        return redirect()->route('loyalty.index')->with('success', 'Voucher redeemed successfully! Check your Profile > My Vouchers.');
    }

    // --- Admin Voucher Management ---

    /**
     * Show form to create a new voucher (Admin).
     */
    public function adminCreate()
    {
        return view('admin.vouchers.create');
    }

    /**
     * Store a new voucher (Admin).
     */
    public function adminStore(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email', // Identify user by email
            'type' => 'required|in:discount,free_hours',
            'amount' => 'required|integer|min:1',
            'expiry_days' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        // Find customer
        $user = \App\Models\User::where('email', $request->email)->first();
        if (!$user || !$user->customer) {
            return back()->withErrors(['email' => 'Customer profile not found for this user.']);
        }

        Voucher::create([
            'customer_id' => $user->customer->id,
            'voucher_code' => strtoupper(Str::random(8)),
            'description' => $request->description,
            'discount_percent' => $request->type === 'discount' ? $request->amount : null,
            'free_hours' => $request->type === 'free_hours' ? $request->amount : null,
            'expiry_date' => now()->addDays((int) $request->expiry_days),
            'status' => 'active',
        ]);

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher created successfully.');
    }

    /**
     * Show form to edit a voucher (Admin).
     */
    public function adminEdit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.vouchers.edit', compact('voucher'));
    }

    /**
     * Update a voucher (Admin).
     */
    public function adminUpdate(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:active,used,expired',
            'expiry_date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $voucher->update([
            'status' => $request->status,
            'expiry_date' => $request->expiry_date,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher updated.');
    }

    /**
     * Delete a voucher (Admin).
     */
    public function adminDestroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();
        return back()->with('success', 'Voucher deleted.');
    }
}
