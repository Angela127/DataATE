<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Auth\CustomerController;
use App\Http\Controllers\LoyaltyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('mainpage');
})->name('mainpage');


Route::middleware('auth')->group(function (){
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile/personal-data', [ProfileController::class, 'personalData'])->name('profile.personal-data');
    Route::patch('/profile/personal-data', [ProfileController::class, 'updatePersonalData'])->name('profile.personal-data.update');
    Route::get('/profile/driving-license', [ProfileController::class, 'drivingLicense'])->name('profile.driving-license');
    Route::post('/profile/driving-license', [ProfileController::class, 'storeDrivingLicense'])->name('profile.driving-license.store');
    Route::get('/profile/order-history', [BookingController::class, 'orderHistory'])->name('profile.order-history');
    Route::get('/booking/{id}/cancel', [BookingController::class, 'showCancelForm'])->name('booking.cancel.form');
    Route::post('/booking/{id}/cancel', [BookingController::class, 'cancelBooking'])->name('booking.cancel');
    
    // Loyalty Routes
    Route::get('/loyalty', [LoyaltyController::class, 'index'])->name('loyalty.index');
    Route::post('/loyalty/redeem', [LoyaltyController::class, 'redeem'])->name('loyalty.redeem');

   
    Route::get('/booking/calendar', [BookingController::class, 'calendar'])->name('booking.calendar');
    Route::get('/booking/confirm', [BookingController::class, 'confirm'])->name('booking.confirm');
    Route::get('/booking/voucher', [BookingController::class, 'voucher'])->name('booking.voucher');
    Route::get('/booking/pickup', [BookingController::class, 'pickup'])->name('booking.pickup');
    Route::post('/booking/pickup', [BookingController::class, 'storePickup'])->name('booking.pickup.store');
    Route::get('/booking/return', [BookingController::class, 'returnCar'])->name('booking.return');
    Route::post('/booking/return', [BookingController::class, 'storeReturn'])->name('booking.return.store');
    Route::get('/booking/complete', [BookingController::class, 'complete'])->name('booking.complete');
    Route::get('/booking/reminder', [BookingController::class, 'reminder'])->name('booking.reminder');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/pickup_form', function () {
    return view('booking.pickup_form');
    })->name('booking.pickup');

    Route::middleware('checkAdmin')->group(function () {
        Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    });

});

require __DIR__.'/auth.php';
