<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Payment;

class RentalController extends Controller
{
    // ... (existing code top) ...
    
    /**
     * Create rental from booking confirmation (Form Submit).
     */
    public function createRentalFromBooking(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || !$user->customer) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        // Validate
        $request->validate([
            'car' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'pickup_location' => 'required|string',
            'return_location' => 'required|string',
            'destination' => 'required|string',
            'price' => 'numeric',
            'booking_hours' => 'numeric'
        ]);

        $paymentId = 'PAY-' . strtoupper(uniqid()); 
        
        // Create Payment Record
        $payment = Payment::create([
            'payment_id' => $paymentId,
            'customer_id' => $user->customer->customer_id ?? $user->customer->id,
            'amount' => $request->input('price'), // Total price passed from form
            'verification_status' => 'pending',
            'deposit' => 50.00, // Assuming fixed deposit
            'penalty' => 0.00,
            'refund_amount' => 0.00,
        ]);

        // Create Rental Record
        $rental = new Rental();
        $rental->customer_id = $user->customer->customer_id ?? $user->customer->id;
        $rental->plate_no = $request->input('car');
        $rental->start_time = Carbon::parse($request->input('start_time'));
        $rental->end_time = Carbon::parse($request->input('end_time'));
        $rental->pick_up_location = $request->input('pickup_location');
        $rental->return_location = $request->input('return_location');
        $rental->destination = $request->input('destination');
        
        // Default values for required fields (to match DB schema constraints)
        $rental->car_condition_pickup = 'Pending';
        $rental->car_description_pickup = 'Pending';
        $rental->agreement_form = 'Pending';
        $rental->car_condition_return = 'Pending';
        $rental->car_description_return = 'Pending';
        $rental->inspection_form = 'Pending';
        $rental->rating = 0; // Default rating
        
        $rental->payment_id = $paymentId; 
        
        $rental->payment_status = 'pending';
        // $rental->verification_status = 'pending'; // Removed from rental
        
        $rental->save();

        // Redirect to receipt upload
        return redirect()->route('payment.upload_receipt')->with('success', 'Booking created! Please upload your payment receipt.');
    }

    /**
     * Handle receipt upload and save to rental.
     */
    public function storeReceipt(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'receipt' => 'required|file|mimes:jpg,png,jpeg,pdf|max:2048', // Max 2MB
        ]);

        $user = Auth::user();
        
        // Ensure user has a customer profile
        if (!$user->customer) {
            return back()->withErrors(['msg' => 'Customer profile not found. Please complete your profile first.']);
        }

        // Find the latest rental for this CUSTOMER
        $rental = Rental::where('customer_id', $user->customer->customer_id)
            ->latest()
            ->first();

        // Fallback
        if (!$rental) {
             $rental = Rental::where('customer_id', $user->customer->id)->latest()->first();
        }

        if (!$rental || !$rental->payment) {
            return back()->withErrors(['msg' => 'No active payment record found for this account.']);
        }

        // Store the file
        $path = $request->file('receipt')->store('receipts', 'public');

        // Save receipt path and update payment status on PAYMENT table
        $rental->payment->receipt_path = $path;
        $rental->payment->verification_status = 'pending'; // Changed to pending for verification
        $rental->payment->save();
        
        // Update rental status just in case
        $rental->payment_status = 'pending';
        $rental->save();

        // Redirect with success message
        return redirect()->route('mainpage')->with('success', 'Receipt uploaded! Your booking is pending staff approval.');
    }
    /**
     * Store a new rental record (API style).
     */
    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'customer_id' => 'required|string|max:50',
            'plate_no' => 'required|exists:car,plate_no',
            'payment_id' => 'required|string|max:50',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'pick_up_location' => 'required|string|max:255',
            'return_location' => 'required|string|max:255',
            'car_condition_pickup' => 'required|string|max:255',
            'car_description_pickup' => 'nullable|string|max:500',
            'car_condition_return' => 'nullable|string|max:255',
            'car_description_return' => 'nullable|string|max:500',
            'document_signed' => 'required|boolean',
            'payment_status' => 'required|string|in:paid,pending,cancelled',
        ]);

        // Create rental
        $rental = Rental::create($validatedData);

        return response()->json([
            'message' => 'Rental created successfully',
            'rental' => $rental
        ], 201);
    }

    /**
     * Show the booking calendar page.
     */
    public function calendar(Request $request)
    {
        // Fetch all rentals with their car relationship
        $rentals = Rental::with('car')->get();

        // Fetch all cars
        $cars = Car::all();

        // Get optional query parameters or set default values
        $destination = $request->query('destination', null);
        $start_time  = $request->query('start_time', null);
        $end_time    = $request->query('end_time', null);
        $plate_no    = $request->query('car', null);

        // Calculate booking hours
        $bookingHours = 0;
        if ($start_time && $end_time) {
            try {
                $start = Carbon::parse($start_time);
                $end   = Carbon::parse($end_time);
                $bookingHours = $end->diffInHours($start);
            } catch (\Exception $e) {
                $bookingHours = 0;
            }
        }

        // Default deposit
        $depositAmount = 50;

        // Calculate booking price and total price
        $bookingPrice = 0;
        $totalPrice   = $depositAmount;

        $car = null;
        if ($plate_no) {
            $car = Car::where('plate_no', $plate_no)->first();
            if ($car) {
                $bookingPrice = $car->price_hour * $bookingHours;
                $totalPrice   = $depositAmount + $bookingPrice;
            }
        }

        // Pass everything to the view
        return view('booking.calendar', compact(
            'rentals',
            'cars',
            'destination',
            'start_time',
            'end_time',
            'bookingHours',
            'depositAmount',
            'bookingPrice',
            'totalPrice',
            'car'
        ));
    }

    public function voucher(Request $request)
    {
        // Get booking details from query parameters to preserve them
        $bookingParams = $request->all();
        
        $user = \Illuminate\Support\Facades\Auth::user();
        $vouchers = collect();

        if ($user && $user->customer) {
            $vouchers = $user->customer->vouchers()->active()->get();
        }

        return view('booking.voucher', compact('vouchers', 'bookingParams'));
    }

    public function confirm(Request $request)
    {
        // Get the selected car plate number from query parameter
        $plate_no = $request->query('car');
        $car = \App\Models\Car::where('plate_no', $plate_no)->first();

        // Get booking details from query parameters
        $start_time = $request->query('start_time');
        $end_time = $request->query('end_time');

        // Calculate hours from the provided times or use passed hours
        $bookingHours = (int) $request->query('hours', 0);

        if ($start_time && $end_time && $bookingHours == 0) {
            try {
                $start = Carbon::parse($start_time);
                $end = Carbon::parse($end_time);

                $bookingHours = $start->diffInHours($end, false); // false means don't use absolute value

                // If negative or zero, something is wrong
                if ($bookingHours <= 0) {
                    $bookingHours = (int) $request->query('hours', 0);
                }
            } catch (\Exception $e) {
                // If parsing fails, use the hours parameter
                $bookingHours = (int) $request->query('hours', 0);
            }
        }

        // Calculate prices
        $depositAmount = 50;
        $bookingPrice = 0;
        if ($car && $bookingHours > 0) {
            $bookingPrice = $car->price_hour * $bookingHours;
        } else {
            $bookingPrice = (float) $request->query('price', 0);
        }

        // Apply Voucher Logic
        $voucherCode = $request->query('voucher_code');
        $discountAmount = 0;
        $appliedVoucher = null;

        if ($voucherCode) {
            \Log::info('Voucher Code Received: ' . $voucherCode); // Debug
            $user = \Illuminate\Support\Facades\Auth::user();
            
            if ($user && $user->customer) {
                $appliedVoucher = $user->customer->vouchers()
                    ->where('voucher_code', $voucherCode)
                    ->active()
                    ->first();

                if ($appliedVoucher) {
                    \Log::info('Voucher Found: ', $appliedVoucher->toArray()); // Debug
                    if ($appliedVoucher->discount_percent) {
                        $discountAmount = $bookingPrice * ($appliedVoucher->discount_percent / 100);
                    } elseif ($appliedVoucher->free_hours) {
                        // Calculate free hours value
                        $freeHoursValue = $car->price_hour * $appliedVoucher->free_hours;
                        // Cap at booking price (can't go below 0 for booking price)
                        $discountAmount = min($bookingPrice, $freeHoursValue);
                    }
                    \Log::info('Discount Calculated: ' . $discountAmount); // Debug
                } else {
                    \Log::info('Voucher Not Found or Inactive for User: ' . $user->id); 
                }
            } else {
                 \Log::info('User not authenticated or no customer profile');
            }
        }

        $grandTotal = $depositAmount + $bookingPrice + (float) $request->query('addons', 0) - $discountAmount;

        $bookingDetails = [
            'car' => $plate_no,
            'destination' => $request->query('destination', 'Student Mall'),
            'pickup_location' => $request->query('Pickup', 'Student Mall'),
            'return_location' => $request->query('Return', 'Student Mall'),
            'start_time' => $start_time ? Carbon::parse($start_time)->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s'),
            'end_time' => $end_time ? Carbon::parse($end_time)->format('Y-m-d H:i:s') : now()->addDays(3)->format('Y-m-d H:i:s'),
            'booking_hours' => $bookingHours,
            'price' => $bookingPrice,
            'deposit' => $depositAmount,
            'addons' => (float) $request->query('addons', 0),
            'discount' => $discountAmount,
            'voucher_code' => $appliedVoucher ? $appliedVoucher->voucher_code : null,
            'total' => $grandTotal,
        ];

        // Debug: Log the received data (remove in production)
        \Log::info('Confirm Booking Data:', [
            'car' => $plate_no,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'hours' => $bookingHours,
            'pickup' => $request->query('Pickup'),
            'return' => $request->query('Return'),
            'destination' => $request->query('destination'),
            'voucher' => $voucherCode,
            'discount' => $discountAmount
        ]);

        // Return confirm booking view with data
        return view('booking.confirm', compact('car', 'bookingDetails'));
    }

    /**
     * Create rental from booking confirmation (Form Submit).
     */
    // Duplicate method removed.

    /**
     * Handle receipt upload and save to rental.
     */
    // Duplicate storeReceipt removed.

    /**
     * Show pickup form.
     */
    public function pickup()
    {
        return view('booking.pickup_form');
    }

    /**
     * Store pickup data.
     */
    public function storePickup(Request $request)
    {
        // Implement pickup logic later if needed
        return redirect()->route('booking.calendar');
    }

    /**
     * Show return form.
     */
    public function returnCar()
    {
        return view('booking.return');
    }

    /**
     * Store return data.
     */
    public function storeReturn(Request $request)
    {
        // Implement return logic later
        return redirect()->route('booking.complete');
    }

    /**
     * Show completion page.
     */
    public function complete()
    {
        return view('booking.complete');
    }

    /**
     * Show reminder page.
     */
    public function reminder()
    {
        return view('booking.reminder');
    }

    /**
     * Admin: List all rentals.
     */
    public function index()
    {
        $rentals = Rental::with('user', 'car')->latest()->get();
        return view('admin.booking.index', compact('rentals'));
    }
}