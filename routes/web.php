<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('homepage');
});

// Admin Dashboard Route
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth'])->name('admin.dashboard');

// Admin Create Account Routes
Route::get('/admin/create-account', [App\Http\Controllers\AdminController::class, 'showCreateAccount'])
    ->middleware(['auth'])->name('admin.create-account');
    
Route::post('/admin/create-account', [App\Http\Controllers\AdminController::class, 'createAccount'])
    ->middleware(['auth'])->name('admin.store-account');


Route::get('/admin/view-tenants', [App\Http\Controllers\AdminController::class, 'viewTenants'])
    ->middleware(['auth'])->name('admin.view-tenants');

Route::get('/admin/issue-bill', [App\Http\Controllers\AdminController::class, 'showIssueBill'])
    ->middleware(['auth'])->name('admin.issue-bill');
    
Route::post('/admin/issue-bill', [App\Http\Controllers\AdminController::class, 'issueBill'])
    ->middleware(['auth'])->name('admin.store-bill');

Route::get('/admin/view-payments', [App\Http\Controllers\AdminController::class, 'viewPayments'])
    ->middleware(['auth'])->name('admin.view-payments');
    
Route::post('/admin/verify-payment/{paymentID}', [App\Http\Controllers\AdminController::class, 'verifyPayment'])
    ->middleware(['auth'])->name('admin.verify-payment');

Route::get('/admin/view-maintenance', [App\Http\Controllers\AdminController::class, 'viewMaintenanceRequests'])
    ->middleware(['auth'])->name('admin.view-maintenance');
    
Route::post('/admin/update-maintenance/{requestID}', [App\Http\Controllers\AdminController::class, 'updateMaintenanceStatus'])
    ->middleware(['auth'])->name('admin.update-maintenance');

// Tenant Dashboard Route
Route::get('/tenant/dashboard', [App\Http\Controllers\TenantController::class, 'dashboard'])
    ->middleware(['auth'])->name('tenant.dashboard');

Route::get('/tenant/view-bills', [App\Http\Controllers\TenantController::class, 'viewBills'])
    ->middleware(['auth'])->name('tenant.view-bills');

Route::post('/tenant/upload-payment/{billID}', [App\Http\Controllers\TenantController::class, 'uploadPayment'])
    ->middleware(['auth'])->name('tenant.upload-payment');

Route::get('/tenant/create-maintenance', [App\Http\Controllers\TenantController::class, 'showCreateMaintenance'])
    ->middleware(['auth'])->name('tenant.create-maintenance');
    
Route::post('/tenant/create-maintenance', [App\Http\Controllers\TenantController::class, 'createMaintenance'])
    ->middleware(['auth'])->name('tenant.store-maintenance');
    
Route::get('/tenant/view-maintenance', [App\Http\Controllers\TenantController::class, 'viewMaintenance'])
    ->middleware(['auth'])->name('tenant.view-maintenance');

Route::post('/tenant/complete-maintenance/{requestID}', [App\Http\Controllers\TenantController::class, 'completeMaintenance'])
    ->middleware(['auth'])->name('tenant.complete-maintenance');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';