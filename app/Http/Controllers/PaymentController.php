<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;

use App\Notifications\PaymentStatusNotification;

class PaymentController extends Controller
{
    /**
     * Accept payment
     */
    public function accept($id)
    {
        $rental = Rental::with(['customer.user', 'payment'])->findOrFail($id);
        
        if ($rental->payment) {
            $rental->payment->verification_status = 'verified';
            $rental->payment->save();
        }

        $rental->payment_status = 'paid'; 
        $rental->save();

        if ($rental->customer && $rental->customer->user) {
            $rental->customer->user->notify(new PaymentStatusNotification('verified', $rental->id));
        }

        return redirect()->back()->with('success', 'Payment has been verified successfully.');
    }

    /**
     * Decline payment
     */
    public function decline(Request $request, $id)
    {
        $rental = Rental::with(['customer.user', 'payment'])->findOrFail($id);
        
        $reason = $request->input('reason', 'Other'); 
        
        if ($rental->payment) {
            $rental->payment->verification_status = 'failed';
            $rental->payment->save();
        }
        
        $rental->payment_status = 'failed';
        $rental->reject_reason = $reason; // Save reason to rental table
        $rental->save();

        if ($rental->customer && $rental->customer->user) {
            // Determine action URL based on reason
            $actionUrl = null;
            if ($reason === 'Incorrect Amount') {
                $actionUrl = route('payment.refund', $id);
            } else {
                 $actionUrl = route('mainpage');
            }
            
            $rental->customer->user->notify(new PaymentStatusNotification('failed', $rental->id, $reason, $actionUrl));
        }

        return redirect()->back()->with('error', 'Payment has been declined. Reason: ' . $reason);
    }
    
    /**
     * Show Refund Page
     */
    public function refundPage($id)
    {
        $rental = Rental::with(['payment', 'customer', 'car'])->findOrFail($id);
        
        // Security check: ensure current user owns this rental
        if (auth()->check() && auth()->user()->customer && auth()->user()->customer->id !== $rental->customer_id)
        {
             // return redirect()->route('mainpage')->with('error', 'Unauthorized access.');
        }

        return view('payment.refund', compact('rental'));
    }

    /**
     * Store Refund Details
     */
    public function storeRefund(Request $request, $id)
    {
        $request->validate([
            'bank_name' => 'required|string|max:100',
            'bank_account' => 'required|string|max:50',
        ]);

        $rental = Rental::with('payment')->findOrFail($id);

        if ($rental->payment) {
            $rental->payment->bank_name = $request->bank_name;
            $rental->payment->bank_account = $request->bank_account;
            $rental->payment->save();
        }

        return redirect()->route('mainpage')->with('success', 'Refund details submitted successfully. We will process it shortly.');
    }

    /**
     * Show verification page
     */
    public function verifyPage(Request $request, $id = null)
    {
        if ($id) {
            // Show specific rental with car, customer.user, and payment
            $rental = Rental::with(['car', 'customer.user', 'payment'])->find($id);
            $rentals = null;
            $currentTab = null;
        } else {
            // Get current tab from URL (default: pending)
            $currentTab = $request->get('tab', 'pending');
            $rental = null;
            
            // Base query with relationships
            $query = Rental::with(['car', 'customer.user', 'payment']);

            // Filter rentals based on PAYMENT verification_status
            if ($currentTab === 'all') {
                $rentals = $query->get();
            } elseif ($currentTab === 'verified') {
                $rentals = $query->whereHas('payment', function($q) {
                    $q->where('verification_status', 'verified');
                })->get();
            } elseif ($currentTab === 'failed') {
                $rentals = $query->whereHas('payment', function($q) {
                    $q->where('verification_status', 'failed');
                })->get();
            } else {
                // Default: pending
                $rentals = $query->whereHas('payment', function($q) {
                    $q->where('verification_status', 'pending');
                })->get();
                $currentTab = 'pending';
            }
        }
        
        return view('payment.verify', compact('rental', 'rentals', 'currentTab'));
    }
}