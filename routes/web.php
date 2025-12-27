<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Auth\CustomerController;
use App\Http\Controllers\LoyaltyController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminCarController;
use App\Http\Controllers\CustomerCarController;



Route::get('/', [HomeController::class, 'index'])->name('mainpage');



Route::get('/booking/calendar', [RentalController::class, 'calendar'])->name('booking.calendar');
Route::get('/booking/confirm', [RentalController::class, 'confirm'])->name('booking.confirm');
Route::get('/booking/voucher', [RentalController::class, 'voucher'])->name('booking.voucher');
Route::get('/cars', [CustomerCarController::class, 'index'])->name('cars.index');
Route::get('/cars/{plate_no}', [CustomerCarController::class, 'show'])->name('cars.show');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard'); })->name('dashboard');

                Route::middleware(['profile.edit'])->group(function () {
        Route::get('/booking/{car}', [BookingController::class, 'create'])->name('booking.create');
        Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    });

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


        Route::get('/payment/verify/{id?}', [App\Http\Controllers\PaymentController::class, 'verifyPage'])->name('payment.verify');

        // Show upload receipt page
        Route::get('/payment/upload-receipt', function () {
            return view('payment.upload_receipt');
        })->name('payment.upload.form');

        // Booking Creation
        Route::post('/booking/create-rental', [RentalController::class, 'createRentalFromBooking'])->name('booking.create_rental');

        // Handle upload (Consolidated to RentalController)
        Route::post('/payment/upload-receipt', [RentalController::class, 'storeReceipt'])
            ->name('payment.storeReceipt');

        Route::middleware('checkAdmin')->group(function () {
            Route::get('/booking', [RentalController::class, 'index'])->name('booking.index');
            Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
            Route::get('/admin/vouchers', [AdminController::class, 'voucherStats'])->name('admin.vouchers.index');
            Route::get('/admin/loyalty', [AdminController::class, 'customerLoyalty'])->name('admin.loyalty.index');

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

            // Admin Car Management
            Route::get('/admin/cars', [AdminCarController::class, 'index'])->name('admin.cars.index');
            Route::get('/admin/cars/create', [AdminCarController::class, 'create'])->name('admin.cars.create');
            Route::post('/admin/cars', [AdminCarController::class, 'store'])->name('admin.cars.store');
            Route::get('/admin/cars/{plate_no}/edit', [AdminCarController::class, 'edit'])->name('admin.cars.edit');
            Route::put('/admin/cars/{plate_no}', [AdminCarController::class, 'update'])->name('admin.cars.update');
            Route::delete('/admin/cars/{plate_no}', [AdminCarController::class, 'destroy'])->name('admin.cars.destroy');
        });

    });

    require __DIR__ . '/auth.php';
});
