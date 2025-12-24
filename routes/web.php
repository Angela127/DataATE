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

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile
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
    Route::get('/loyalty/redeem', [VoucherController::class, 'redeemPage'])->name('loyalty.redeem');
    Route::post('/loyalty/redeem', [VoucherController::class, 'store'])->name('voucher.store');
    Route::get('/profile/vouchers', [VoucherController::class, 'index'])->name('profile.vouchers');

    // Rental
    Route::get('/test-rental', [RentalController::class, 'store']);
    Route::get('/booking/calendar', [RentalController::class, 'calendar'])->name('booking.calendar');
    Route::get('/booking/confirm', [RentalController::class, 'confirm'])->name('booking.confirm');
    Route::get('/booking/voucher', [RentalController::class, 'voucher'])->name('booking.voucher');
    Route::get('/booking/pickup', [RentalController::class, 'pickup'])->name('booking.pickup');
    Route::post('/booking/pickup', [RentalController::class, 'storePickup'])->name('booking.pickup.store');
    Route::get('/booking/return', [RentalController::class, 'returnCar'])->name('booking.return');
    Route::post('/booking/return', [RentalController::class, 'storeReturn'])->name('booking.return.store');
    Route::get('/booking/complete', [RentalController::class, 'complete'])->name('booking.complete');
    Route::get('/booking/reminder', [RentalController::class, 'reminder'])->name('booking.reminder');
    Route::post('/booking', [RentalController::class, 'store'])->name('booking.store');

    // ✅ Upload Receipt Page (shows QR + allows upload)
    Route::get('/upload-receipt', function () {
        return view('payment.upload_receipt'); // Contains QR + upload form
    })->name('payment.upload_receipt');

    // ✅ Handle upload
    Route::post('/payment/upload-receipt', [RentalController::class, 'storeReceipt'])->name('payment.storeReceipt');

    // ✅ Create rental from confirm (before upload)
    Route::post('/booking/create-rental', [RentalController::class, 'createRentalFromBooking'])->name('booking.create_rental');

    // Admin
    Route::middleware('checkAdmin')->group(function () {
        Route::get('/booking', [RentalController::class, 'index'])->name('booking.index');
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/voucher-stats', [AdminController::class, 'voucherStats'])->name('admin.voucher_stats');
        Route::get('/admin/customer-loyalty', [AdminController::class, 'customerLoyalty'])->name('admin.customer_loyalty');

        // Admin Voucher CRUD
        Route::get('/admin/vouchers/create', [VoucherController::class, 'adminCreate'])->name('admin.vouchers.create');
        Route::post('/admin/vouchers', [VoucherController::class, 'adminStore'])->name('admin.vouchers.store');
        Route::get('/admin/vouchers/{id}/edit', [VoucherController::class, 'adminEdit'])->name('admin.vouchers.edit');
        Route::put('/admin/vouchers/{id}', [VoucherController::class, 'adminUpdate'])->name('admin.vouchers.update');
        Route::delete('/admin/vouchers/{id}', [VoucherController::class, 'adminDestroy'])->name('admin.vouchers.destroy');

        // Admin Loyalty Rules
        Route::get('/admin/loyalty/rules', [LoyaltyController::class, 'adminRules'])->name('admin.loyalty.rules');
        Route::post('/admin/loyalty/rules', [LoyaltyController::class, 'adminUpdateRules'])->name('admin.loyalty.rules.update');

        // Admin Document Approvals
        Route::get('/admin/document-approvals', [AdminController::class, 'documentApprovals'])->name('admin.document_approvals');
        Route::post('/admin/documents/{customerId}/approve', [AdminController::class, 'approveDocuments'])->name('admin.documents.approve');
        Route::post('/admin/documents/{customerId}/reject', [AdminController::class, 'rejectDocuments'])->name('admin.documents.reject');
    });

    
});

require __DIR__.'/auth.php';