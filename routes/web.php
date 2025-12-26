<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Auth\CustomerController;
use App\Http\Controllers\LoyaltyController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\AdminController;




Route::get('/', [HomeController::class, 'index'])->name('mainpage');

Route::get('/booking/calendar', [RentalController::class, 'calendar'])->name('booking.calendar');
Route::get('/booking/confirm', [RentalController::class, 'confirm'])->name('booking.confirm');
Route::get('/booking/voucher', [RentalController::class, 'voucher'])->name('booking.voucher');

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
    
    // Voucher Routes
    Route::get('/loyalty/redeem', [VoucherController::class, 'redeemPage'])->name('loyalty.redeem'); // Selection Page
    Route::post('/loyalty/redeem', [VoucherController::class, 'store'])->name('voucher.store'); // Process Redemption
    
    Route::get('/profile/vouchers', [VoucherController::class, 'index'])->name('profile.vouchers');

    Route::get('/test-rental', [RentalController::class, 'store']);
    Route::get('/test-rental', [RentalController::class, 'store']);
    Route::get('/booking/pickup', [RentalController::class, 'pickup'])->name('booking.pickup');
    Route::post('/booking/pickup', [RentalController::class, 'storePickup'])->name('booking.pickup.store');
    Route::get('/booking/return', [RentalController::class, 'returnCar'])->name('booking.return');
    Route::post('/booking/return', [RentalController::class, 'storeReturn'])->name('booking.return.store');
    Route::get('/booking/complete', [RentalController::class, 'complete'])->name('booking.complete');
    Route::get('/booking/reminder', [RentalController::class, 'reminder'])->name('booking.reminder');
    Route::post('/booking', [RentalController::class, 'store'])->name('booking.store');
    Route::get('/booking/pickup_form', function () {
    return view('booking.pickup_form');
    })->name('booking.pickup');
    
    //upload receipts
    Route::get('/upload-receipt', function () {
    return view('payment.upload_receipt'); // 
    })->name('payment.upload_receipt');

   Route::get('/payment/verify/{id?}', [App\Http\Controllers\PaymentController::class, 'verifyPage'])->name('payment.verify');
   


    Route::post('/payment/verify/{id}/accept', [App\Http\Controllers\PaymentController::class, 'accept'])->name('payment.verify.accept');
    Route::post('/payment/verify/{id}/decline', [App\Http\Controllers\PaymentController::class, 'decline'])->name('payment.verify.decline');
    
    // Refund Routes
    Route::get('/payment/refund/{id}', [App\Http\Controllers\PaymentController::class, 'refundPage'])->name('payment.refund');
    Route::post('/payment/refund/{id}', [App\Http\Controllers\PaymentController::class, 'storeRefund'])->name('payment.refund.store');

    Route::post('/booking/create-rental', [RentalController::class, 'createRentalFromBooking'])->name('booking.create_rental');
    Route::post('/payment/upload-receipt', [RentalController::class, 'storeReceipt'])->name('payment.storeReceipt');

    Route::middleware('checkAdmin')->group(function () {
        Route::get('/booking', [RentalController::class, 'index'])->name('booking.index');
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/voucher-stats', [AdminController::class, 'voucherStats'])->name('admin.voucher_stats');
        Route::get('/admin/customer-loyalty', [AdminController::class, 'customerLoyalty'])->name('admin.customer_loyalty');
    });

});

require __DIR__.'/auth.php';
