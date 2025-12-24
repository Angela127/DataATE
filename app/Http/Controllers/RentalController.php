<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\Car;
use Carbon\Carbon;

class RentalController extends Controller
{
    /**
     * Store a new rental record.
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
            'destination' => $request->query('destination', 'Student Mall'),
            'pickup_location' => $request->query('Pickup', 'Student Mall'),
            'return_location' => $request->query('Return', 'Student Mall'),
            'start_time' => $start_time ?? now(),
            'end_time' => $end_time ?? now()->addDays(3),
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
}