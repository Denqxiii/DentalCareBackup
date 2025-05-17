<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    AdminController,
    UserController,
    PatientController,
    AppointmentController,
    TreatmentController,
    PaymentController,
    ReportController,
    PrescriptionController,
    InventoryController
};

Route::get('/', function () {
    return view('homepage');
})->name('homepage');

// Public routes (no authentication required)
Route::group(['middleware' => 'guest'], function() {
    // Booking routes
    Route::get('/book-appointment', [AppointmentController::class, 'createPublic'])
         ->name('book.appointment');
         
    Route::post('/book-appointment', [AppointmentController::class, 'store'])->name('appointment.store');
    
    Route::get('/appointment/confirmation/{id}', [AppointmentController::class, 'confirmation'])
        ->name('appointment.confirmation');

    Route::get('/api/patient/{patientId}', [AppointmentController::class, 'getPatientDetails']);

    // Patient Registration
    Route::get('/patients/register', [PatientController::class, 'showRegistrationForm'])
         ->name('patients.showRegister');
    Route::post('/patients/register', [PatientController::class, 'register'])
         ->name('patients.register');

    // Authentication Routes
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])
         ->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
    
    // Password Reset Routes
    Route::get('/password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])
         ->name('password.request');
    Route::post('/password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])
         ->name('password.email');
    Route::get('/password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])
         ->name('password.reset');
    Route::post('/password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])
         ->name('password.update');
});

// Authenticated Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])
         ->name('logout');
    
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('users', UserController::class);
    
    // Patients
    Route::resource('patients', PatientController::class)->except(['create', 'store']);
    
    // Appointments
    Route::resource('appointments', AppointmentController::class);
    
    // Treatments
    Route::resource('treatments', TreatmentController::class);
    
    // Payments
    Route::prefix('payments')->group(function() {
        Route::get('/', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/create/{appointment}', [PaymentController::class, 'create'])->name('payments.create');
        Route::post('/', [PaymentController::class, 'store'])->name('payments.store');
        Route::get('/{payment}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');
    });
    
    // Prescriptions
    Route::resource('prescriptions', PrescriptionController::class);
    
    // Reports
    Route::prefix('reports')->group(function() {
        Route::get('/', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/financial', [ReportController::class, 'financial'])->name('reports.financial');
        Route::get('/appointments', [ReportController::class, 'appointments'])->name('reports.appointments');
    });
    
    // Inventory Routes
    Route::prefix('inventory')->group(function() {
        Route::get('/', [InventoryController::class, 'index'])->name('inventory.index');
        Route::get('/create', [InventoryController::class, 'create'])->name('inventory.create');
        Route::post('/', [InventoryController::class, 'store'])->name('inventory.store');
        Route::get('/{item}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
        Route::put('/{item}', [InventoryController::class, 'update'])->name('inventory.update');
        
        // Stock Movements
        Route::get('/{item}/movements', [InventoryController::class, 'movements'])->name('inventory.movements');
        Route::get('/movements/create', [InventoryController::class, 'createMovement'])->name('inventory.movements.create');
        Route::post('/movements', [InventoryController::class, 'storeMovement'])->name('inventory.movements.store');
    });
});