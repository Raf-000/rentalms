<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ============================================
// PUBLIC ROUTES
// ============================================

Route::get('/', function () {
    return view('homepage');
});

// View Available Rooms Route
Route::get('/available-rooms', [App\Http\Controllers\HomeController::class, 'availableRooms'])
    ->name('available-rooms');

// Book Viewing Routes
Route::get('/book-viewing', [App\Http\Controllers\HomeController::class, 'bookViewing'])
    ->name('book-viewing');
    
Route::post('/book-viewing', [App\Http\Controllers\HomeController::class, 'storeBooking'])
    ->name('store-booking');

Route::post('/book-viewing/ajax', [App\Http\Controllers\HomeController::class, 'storeBookingAjax'])
    ->name('store-booking-ajax');


// ============================================
// ADMIN ROUTES (Protected)
// ============================================

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])
        ->name('dashboard');

    // Create Account
    Route::get('/create-account', [App\Http\Controllers\AdminController::class, 'showCreateAccount'])
        ->name('create-account');
    Route::post('/create-account', [App\Http\Controllers\AdminController::class, 'createAccount'])
        ->name('store-account');

    // View Tenants
    Route::get('/view-tenants', [App\Http\Controllers\AdminController::class, 'viewTenants'])
        ->name('view-tenants');

    // Issue Bill
    Route::get('/issue-bill', [App\Http\Controllers\AdminController::class, 'showIssueBill'])
        ->name('issue-bill');
    Route::post('/issue-bill', [App\Http\Controllers\AdminController::class, 'issueBill'])
        ->name('store-bill');

    // View Payments
    Route::get('/view-payments', [App\Http\Controllers\AdminController::class, 'viewPayments'])
        ->name('view-payments');
    Route::post('/verify-payment/{paymentID}', [App\Http\Controllers\AdminController::class, 'verifyPayment'])
        ->name('verify-payment');
    
    // AJAX Payment Actions
    Route::post('/payments/{payment}/verify-ajax', [App\Http\Controllers\AdminController::class, 'verifyPaymentAjax'])
        ->name('payments.verify-ajax');
    Route::post('/payments/{payment}/reject-ajax', [App\Http\Controllers\AdminController::class, 'rejectPaymentAjax'])
        ->name('payments.reject-ajax');

    // View Maintenance
    Route::get('/view-maintenance', [App\Http\Controllers\AdminController::class, 'viewMaintenanceRequests'])
        ->name('view-maintenance');
    Route::post('/update-maintenance/{requestID}', [App\Http\Controllers\AdminController::class, 'updateMaintenanceStatus'])
        ->name('update-maintenance');
});


// ============================================
// TENANT ROUTES (Protected)
// ============================================

Route::middleware(['auth'])->prefix('tenant')->name('tenant.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\TenantController::class, 'dashboard'])
        ->name('dashboard');

    // View Bills
    Route::get('/view-bills', [App\Http\Controllers\TenantController::class, 'viewBills'])
        ->name('view-bills');
    Route::post('/upload-payment/{billID}', [App\Http\Controllers\TenantController::class, 'uploadPayment'])
        ->name('upload-payment');

    // Maintenance Requests
    Route::get('/create-maintenance', [App\Http\Controllers\TenantController::class, 'showCreateMaintenance'])
        ->name('create-maintenance');
        
    Route::post('/create-maintenance', [App\Http\Controllers\TenantController::class, 'createMaintenance'])
        ->name('store-maintenance');

    Route::get('/view-maintenance', [App\Http\Controllers\TenantController::class, 'viewMaintenance'])
        ->name('view-maintenance');
        
    Route::post('/complete-maintenance/{requestID}', [App\Http\Controllers\TenantController::class, 'completeMaintenance'])
        ->name('complete-maintenance');

    Route::post('/complete-maintenance/{requestID}/ajax', [App\Http\Controllers\TenantController::class, 'completeMaintenanceAjax'])
        ->name('complete-maintenance-ajax');
    
});


// ============================================
// PROFILE ROUTES (Protected)
// ============================================

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';