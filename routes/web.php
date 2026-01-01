<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SuratPerjanjianController;
use App\Http\Controllers\KuitansiController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/api/dashboard/chart', [DashboardController::class, 'getChartData'])
    ->middleware(['auth'])
    ->name('dashboard.chart');

Route::get('/components-preview', function () {
    return view('components-preview');
})->middleware(['auth'])->name('components.preview');

Route::get('/components-demo', function () {
    return view('components-demo');
})->middleware(['auth'])->name('components.demo');

Route::get('/demo/notifications-modals', function () {
    return view('demo.notifications-modals');
})->middleware(['auth'])->name('demo.notifications-modals');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Invoice Management Routes (with role-based permissions)
Route::middleware(['auth'])->group(function () {
    // All authenticated users can view, create, edit invoices
    Route::get('/invoices/input', [InvoiceController::class, 'input'])->middleware('permission:create-invoices')->name('invoices.input');
    Route::post('/invoices/store-with-items', [InvoiceController::class, 'storeWithItems'])->middleware('permission:create-invoices')->name('invoices.storeWithItems');
    Route::get('/invoices/generate-number', [InvoiceController::class, 'generateInvoiceNumber'])->middleware('permission:create-invoices')->name('invoices.generateNumber');
    Route::post('/invoices/store-quick', [InvoiceController::class, 'storeQuick'])->middleware('permission:create-invoices')->name('invoices.storeQuick');
    
    // Workflow: Create Invoice from PKS
    Route::get('/invoices/from-pks/{pks}', [InvoiceController::class, 'createFromPks'])->middleware('permission:create-invoices')->name('invoices.createFromPks');
    Route::post('/invoices/from-pks/{pks}', [InvoiceController::class, 'storeFromPks'])->middleware('permission:create-invoices')->name('invoices.storeFromPks');
    Route::get('/invoices/available-pks', [InvoiceController::class, 'getAvailablePks'])->middleware('permission:view-invoices')->name('invoices.availablePks');
    
    // DataTables server-side endpoint
    Route::get('/invoices/data', [InvoiceController::class, 'getData'])->middleware('permission:view-invoices')->name('invoices.data');
    
    Route::get('/invoices', [InvoiceController::class, 'index'])->middleware('permission:view-invoices')->name('invoices.index');
    Route::get('/invoices/create', [InvoiceController::class, 'create'])->middleware('permission:create-invoices')->name('invoices.create');
    Route::post('/invoices', [InvoiceController::class, 'store'])->middleware('permission:create-invoices')->name('invoices.store');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->middleware('permission:view-invoices')->name('invoices.show');
    Route::get('/invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->middleware('permission:edit-invoices')->name('invoices.edit');
    Route::put('/invoices/{invoice}', [InvoiceController::class, 'update'])->middleware('permission:edit-invoices')->name('invoices.update');
    Route::patch('/invoices/{invoice}', [InvoiceController::class, 'update'])->middleware('permission:edit-invoices');
    
    // Only Marketing Manager can delete invoices
    Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])->middleware('permission:delete-invoices')->name('invoices.destroy');
});

// User Management Routes
Route::middleware(['auth'])->group(function () {
    // Users
    Route::get('/users/data', [App\Http\Controllers\UserController::class, 'getData'])->name('users.data');
    Route::resource('users', App\Http\Controllers\UserController::class);
    
    // Roles
    Route::get('/roles/data', [App\Http\Controllers\RoleController::class, 'getData'])->name('roles.data');
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    
    // Permissions
    Route::get('/permissions/data', [App\Http\Controllers\PermissionController::class, 'getData'])->name('permissions.data');
    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
});

// Surat Perjanjian Kerjasama (PKS) Routes
Route::middleware(['auth'])->group(function () {
    // DataTables server-side endpoint
    Route::get('/surat-perjanjians/data', [SuratPerjanjianController::class, 'getData'])->middleware('permission:view-pks')->name('surat-perjanjians.data');
    
    // Generate PKS number
    Route::get('/surat-perjanjians/generate-number', [SuratPerjanjianController::class, 'generatePKSNumber'])->middleware('permission:create-pks')->name('surat-perjanjians.generateNumber');
    
    // Quick store from modal
    Route::post('/surat-perjanjians/store-quick', [SuratPerjanjianController::class, 'storeQuick'])->middleware('permission:create-pks')->name('surat-perjanjians.storeQuick');
    
    // Approval route (Marketing Manager only)
    Route::post('/surat-perjanjians/{suratPerjanjian}/approve', [SuratPerjanjianController::class, 'approve'])->middleware('permission:approve-pks')->name('surat-perjanjians.approve');
    Route::post('/surat-perjanjians/{suratPerjanjian}/reject', [SuratPerjanjianController::class, 'reject'])->middleware('permission:approve-pks')->name('surat-perjanjians.reject');
    
    // Update status
    Route::patch('/surat-perjanjians/{suratPerjanjian}/status', [SuratPerjanjianController::class, 'updateStatus'])->middleware('permission:edit-pks')->name('surat-perjanjians.updateStatus');
    
    // Resource routes with permissions
    Route::get('/surat-perjanjians', [SuratPerjanjianController::class, 'index'])->middleware('permission:view-pks')->name('surat-perjanjians.index');
    Route::get('/surat-perjanjians/create', [SuratPerjanjianController::class, 'create'])->middleware('permission:create-pks')->name('surat-perjanjians.create');
    Route::post('/surat-perjanjians', [SuratPerjanjianController::class, 'store'])->middleware('permission:create-pks')->name('surat-perjanjians.store');
    Route::get('/surat-perjanjians/{suratPerjanjian}', [SuratPerjanjianController::class, 'show'])->middleware('permission:view-pks')->name('surat-perjanjians.show');
    Route::get('/surat-perjanjians/{suratPerjanjian}/edit', [SuratPerjanjianController::class, 'edit'])->middleware('permission:edit-pks')->name('surat-perjanjians.edit');
    Route::put('/surat-perjanjians/{suratPerjanjian}', [SuratPerjanjianController::class, 'update'])->middleware('permission:edit-pks')->name('surat-perjanjians.update');
    Route::patch('/surat-perjanjians/{suratPerjanjian}', [SuratPerjanjianController::class, 'update'])->middleware('permission:edit-pks');
    
    // Only Marketing Manager can delete PKS
    Route::delete('/surat-perjanjians/{suratPerjanjian}', [SuratPerjanjianController::class, 'destroy'])->middleware('permission:delete-pks')->name('surat-perjanjians.destroy');
});

// Kuitansi Routes
Route::middleware(['auth'])->group(function () {
    // DataTables server-side endpoint
    Route::get('/kuitansis/data', [KuitansiController::class, 'getData'])->middleware('permission:view-kuitansi')->name('kuitansis.data');
    
    // Generate Kuitansi number
    Route::get('/kuitansis/generate-number', [KuitansiController::class, 'generateKuitansiNumber'])->middleware('permission:create-kuitansi')->name('kuitansis.generateNumber');
    
    // Quick store from modal
    Route::post('/kuitansis/store-quick', [KuitansiController::class, 'storeQuick'])->middleware('permission:create-kuitansi')->name('kuitansis.storeQuick');
    
    // Workflow: Create Kuitansi from Invoice
    Route::get('/kuitansis/from-invoice/{invoice}', [KuitansiController::class, 'createFromInvoice'])->middleware('permission:create-kuitansi')->name('kuitansis.createFromInvoice');
    Route::post('/kuitansis/from-invoice/{invoice}', [KuitansiController::class, 'storeFromInvoice'])->middleware('permission:create-kuitansi')->name('kuitansis.storeFromInvoice');
    Route::get('/kuitansis/available-invoices', [KuitansiController::class, 'getAvailableInvoices'])->middleware('permission:view-kuitansi')->name('kuitansis.availableInvoices');
    
    // Mark as Lunas
    Route::post('/kuitansis/{kuitansi}/mark-lunas', [KuitansiController::class, 'markLunas'])->middleware('permission:edit-kuitansi')->name('kuitansis.markLunas');
    
    // Update status
    Route::patch('/kuitansis/{kuitansi}/status', [KuitansiController::class, 'updateStatus'])->middleware('permission:edit-kuitansi')->name('kuitansis.updateStatus');
    
    // Resource routes with permissions
    Route::get('/kuitansis', [KuitansiController::class, 'index'])->middleware('permission:view-kuitansi')->name('kuitansis.index');
    Route::get('/kuitansis/create', [KuitansiController::class, 'create'])->middleware('permission:create-kuitansi')->name('kuitansis.create');
    Route::post('/kuitansis', [KuitansiController::class, 'store'])->middleware('permission:create-kuitansi')->name('kuitansis.store');
    Route::get('/kuitansis/{kuitansi}', [KuitansiController::class, 'show'])->middleware('permission:view-kuitansi')->name('kuitansis.show');
    Route::get('/kuitansis/{kuitansi}/edit', [KuitansiController::class, 'edit'])->middleware('permission:edit-kuitansi')->name('kuitansis.edit');
    Route::put('/kuitansis/{kuitansi}', [KuitansiController::class, 'update'])->middleware('permission:edit-kuitansi')->name('kuitansis.update');
    Route::patch('/kuitansis/{kuitansi}', [KuitansiController::class, 'update'])->middleware('permission:edit-kuitansi');
    
    // Only Marketing Manager can delete Kuitansi
    Route::delete('/kuitansis/{kuitansi}', [KuitansiController::class, 'destroy'])->middleware('permission:delete-kuitansi')->name('kuitansis.destroy');
});

require __DIR__.'/auth.php';
