<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class RentalController extends Controller
{
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
        // Check authentication
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check profile completion (documents uploaded)
        if (!$user->customer || !$user->customer->hasUploadedAllDocuments()) {
            return redirect()->route('profile.edit')
                ->with('error', 'Please complete your profile and upload all required documents (License, IC, Matric Card) before booking a car.');
        }

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

     public function voucher()
    {
        return view('booking.voucher');
    }
    
  public function initiate(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id'
        ]);

<<<<<<< Updated upstream
<<<<<<< Updated upstream
        // Store the selected car ID in the session
        session(['selected_car_id' => $request->car_id]);

        // Redirect directly to profile
        return redirect()->route('profile.show')
            ->with('info', 'Please complete your profile to proceed with the rental.');
    }
    
    public function confirm(Request $request)
    {
        // Check if customer has approved documents
        $user = Auth::user();
        if ($user && $user->customer) {
            // Check if documents are uploaded (Profile Complete)
            if (!$user->customer->hasUploadedAllDocuments()) {
                return redirect()->route('profile.edit')->with('error', 'Please complete your profile and upload all required documents (License, IC, Matric Card) before booking a car.');
            }
        } else {
            return redirect()->route('profile.edit')->with('error', 'Please complete your profile and upload required documents before renting a car.');
        }

        // Get the selected car plate number from query parameter
        $plate_no = $request->query('car');
        $car = \App\Models\Car::where('plate_no', $plate_no)->first();
=======
=======
>>>>>>> Stashed changes
public function confirm(Request $request)
{
    // Get the selected car plate number from query parameter
    $plate_no = $request->query('car');
    $car = \App\Models\Car::where('plate_no', $plate_no)->first();
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes

    // Get booking details from query parameters
    $start_time = $request->query('start_time');
    $end_time = $request->query('end_time');
    
    // Calculate hours from the provided times or use passed hours
    $bookingHours = (int) $request->query('hours', 0);
    
    if ($start_time && $end_time && $bookingHours == 0) {
        try {
            $start = Carbon::parse($start_time);
            $end = Carbon::parse($end_time);
            $bookingHours = $start->diffInHours($end, false);
            
            if ($bookingHours <= 0) {
                $bookingHours = (int) $request->query('hours', 0);
            }
        } catch (\Exception $e) {
            $bookingHours = (int) $request->query('hours', 0);
        }
<<<<<<< Updated upstream
<<<<<<< Updated upstream
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
        \Log::info('Voucher Code Received: ' . $voucherCode);
        $user = \Illuminate\Support\Facades\Auth::user();
        
        if ($user && $user->customer) {
            $appliedVoucher = $user->customer->vouchers()
                ->where('voucher_code', $voucherCode)
                ->active()
                ->first();

            if ($appliedVoucher) {
                \Log::info('Voucher Found: ', $appliedVoucher->toArray());
                if ($appliedVoucher->discount_percent) {
                    $discountAmount = $bookingPrice * ($appliedVoucher->discount_percent / 100);
                } elseif ($appliedVoucher->free_hours) {
                    $freeHoursValue = $car->price_hour * $appliedVoucher->free_hours;
                    $discountAmount = min($bookingPrice, $freeHoursValue);
                }
                \Log::info('Discount Calculated: ' . $discountAmount);
            } else {
                \Log::info('Voucher Not Found or Inactive for User: ' . $user->id); 
            }
        } else {
            \Log::info('User not authenticated or no customer profile');
        }
    }

    $grandTotal = $depositAmount + $bookingPrice + (float) $request->query('addons', 0) - $discountAmount;

    // BUILD THE BOOKING DETAILS ARRAY ONCE - WITH ALL DATA INCLUDING COORDINATES
    $bookingDetails = [
        // Basic booking info
        'car' => $plate_no,
        'destination' => $request->query('destination', ''),
        'pickup_location' => $request->query('Pickup', 'Student Mall'),
        'return_location' => $request->query('Return', 'Student Mall'),
        'start_time' => $start_time ? Carbon::parse($start_time)->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s'),
        'end_time' => $end_time ? Carbon::parse($end_time)->format('Y-m-d H:i:s') : now()->addDays(3)->format('Y-m-d H:i:s'),
        'booking_hours' => $bookingHours,
        
        // Price info
        'price' => $bookingPrice,
        'deposit' => $depositAmount,
        'addons' => (float) $request->query('addons', 0),
        'discount' => $discountAmount,
        'voucher_code' => $appliedVoucher ? $appliedVoucher->voucher_code : null,
        'total' => $grandTotal,
        
        // COORDINATES - THIS WAS MISSING!
        'pickup_lat' => $request->query('pickup_lat', '1.558557'),
        'pickup_lng' => $request->query('pickup_lng', '103.636647'),
        'return_lat' => $request->query('return_lat', '1.558557'),
        'return_lng' => $request->query('return_lng', '103.636647'),
        'destination_lat' => $request->query('destination_lat', ''),
        'destination_lng' => $request->query('destination_lng', ''),
    ];

    // Debug: Log the received data
    \Log::info('Confirm Booking Data:', $bookingDetails);

    // Return confirm booking view with data
    return view('booking.confirm', compact('car', 'bookingDetails'));
}

    /**
     * Create rental from booking confirmation.
     */
    public function createRentalFromBooking(Request $request)
    {
        $user = Auth::user();
        
        // 1. Create Payment Record (Pending)
        $paymentId = 'PAY-' . time() . '-' . rand(1000, 9999);
        $amount = (float) $request->input('total');
        
        // If customer_id in payments refers to 'id' in customers table, we need to fetch it.
        // Assuming Rental table customer_id stores User ID (based on storeReceipt usage), 
        // BUT Payments table migration says foreign key to customers.customer_id.
        // Let's check Customer model. Customer has customer_id string (C000001).
        
        $customer = $user->customer;
        if (!$customer) {
             return redirect()->back()->with('error', 'Customer profile not found.');
        }

        // Create Payment
        \DB::table('payments')->insert([
            'payment_id' => $paymentId,
            'customer_id' => $customer->customer_id, // Use actual customer_id string
            'amount' => $amount,
            'verification_status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Create Rental Record
        $rental = Rental::create([
            'customer_id' => $user->id, // Rental table uses User ID based on existing code context
            'plate_no' => $request->input('car'),
            'payment_id' => $paymentId,
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'pick_up_location' => $request->input('pickup_location'),
            'return_location' => $request->input('return_location'),
            'destination' => $request->input('destination'),
            'payment_status' => 'pending',
            'pickup_lat' => $request->input('pickup_lat'),
            'pickup_lng' => $request->input('pickup_lng'),
            'return_lat' => $request->input('return_lat'),
            'return_lng' => $request->input('return_lng'),
            'destination_lat' => $request->input('destination_lat'),
            'destination_lng' => $request->input('destination_lng'),
        ]);

        return redirect()->route('payment.upload.form')->with('success', 'Booking initiated! Please upload your payment receipt.');
    }

    /**
     * Handle receipt upload and save to payment.
     */
    public function storeReceipt(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'receipt' => 'required|file|mimes:jpg,png,jpeg,pdf|max:2048', // Max 2MB
        ]);

        $user = Auth::user();

        // Store the file in receipt folder
        $path = $request->file('receipt')->store('receipts', 'public');

        // Find the latest rental for this user
        $rental = Rental::where('customer_id', $user->id)
            ->latest()
            ->first();

        if (!$rental) {
            return back()->withErrors('No rental record found for this user.');
        }

        // Find the associated payment
        $payment = \DB::table('payments')->where('payment_id', $rental->payment_id)->first();

        if ($payment) {
            // Update Payment record
            \DB::table('payments')->where('payment_id', $rental->payment_id)->update([
                'receipt_path' => $path,
                'verification_status' => 'pending',
                'updated_at' => now()
            ]);
        }
        
        // Update Rental Status
        $rental->payment_status = 'paid'; // Or 'pending' depending on flow, usually 'paid' implies user action done
        $rental->save();

        // Redirect with success message
        return redirect()->route('mainpage')->with('success', 'Receipt uploaded! Your booking is pending staff approval.');
    }

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
    

=======
    }

>>>>>>> Stashed changes
=======
    }

>>>>>>> Stashed changes
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
        \Log::info('Voucher Code Received: ' . $voucherCode);
        $user = \Illuminate\Support\Facades\Auth::user();
        
        if ($user && $user->customer) {
            $appliedVoucher = $user->customer->vouchers()
                ->where('voucher_code', $voucherCode)
                ->active()
                ->first();

            if ($appliedVoucher) {
                \Log::info('Voucher Found: ', $appliedVoucher->toArray());
                if ($appliedVoucher->discount_percent) {
                    $discountAmount = $bookingPrice * ($appliedVoucher->discount_percent / 100);
                } elseif ($appliedVoucher->free_hours) {
                    $freeHoursValue = $car->price_hour * $appliedVoucher->free_hours;
                    $discountAmount = min($bookingPrice, $freeHoursValue);
                }
                \Log::info('Discount Calculated: ' . $discountAmount);
            } else {
                \Log::info('Voucher Not Found or Inactive for User: ' . $user->id); 
            }
        } else {
            \Log::info('User not authenticated or no customer profile');
        }
    }

    $grandTotal = $depositAmount + $bookingPrice + (float) $request->query('addons', 0) - $discountAmount;

    // BUILD THE BOOKING DETAILS ARRAY ONCE - WITH ALL DATA INCLUDING COORDINATES
    $bookingDetails = [
        // Basic booking info
        'car' => $plate_no,
        'destination' => $request->query('destination', ''),
        'pickup_location' => $request->query('Pickup', 'Student Mall'),
        'return_location' => $request->query('Return', 'Student Mall'),
        'start_time' => $start_time ? Carbon::parse($start_time)->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s'),
        'end_time' => $end_time ? Carbon::parse($end_time)->format('Y-m-d H:i:s') : now()->addDays(3)->format('Y-m-d H:i:s'),
        'booking_hours' => $bookingHours,
        
        // Price info
        'price' => $bookingPrice,
        'deposit' => $depositAmount,
        'addons' => (float) $request->query('addons', 0),
        'discount' => $discountAmount,
        'voucher_code' => $appliedVoucher ? $appliedVoucher->voucher_code : null,
        'total' => $grandTotal,
        
        // COORDINATES - THIS WAS MISSING!
        'pickup_lat' => $request->query('pickup_lat', '1.558557'),
        'pickup_lng' => $request->query('pickup_lng', '103.636647'),
        'return_lat' => $request->query('return_lat', '1.558557'),
        'return_lng' => $request->query('return_lng', '103.636647'),
        'destination_lat' => $request->query('destination_lat', ''),
        'destination_lng' => $request->query('destination_lng', ''),
    ];

    // Debug: Log the received data
    \Log::info('Confirm Booking Data:', $bookingDetails);

    // Return confirm booking view with data
    return view('booking.confirm', compact('car', 'bookingDetails'));
}
}