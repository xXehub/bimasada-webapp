<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/components-preview', function () {
    return view('components-preview');
})->middleware(['auth'])->name('components.preview');

Route::get('/components-demo', function () {
    return view('components-demo');
})->middleware(['auth'])->name('components.demo');

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

require __DIR__.'/auth.php';
