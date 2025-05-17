<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Admin\PatientController as AdminPatientController;

// Register middleware
Route::aliasMiddleware('admin', \App\Http\Middleware\AdminMiddleware::class);

Route::get('/', function () {
    return view('homepage');
})->name('homepage');

// Debug route
Route::get('/check-auth', function () {
    if (auth()->check()) {
        $user = auth()->user();
        return "Logged in as: " . $user->name . 
               "<br>Admin status: " . ($user->is_admin ? 'Yes' : 'No') .
               "<br>User details: " . json_encode($user->toArray());
    }
    return "Not logged in";
});

// Public routes (no authentication required)
Route::middleware('guest')->group(function() {
    // Authentication Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    // Booking routes
    Route::get('/book-appointment', [AppointmentController::class, 'createPublic'])
         ->name('book.appointment');
    Route::post('/appointments/guest', [AppointmentController::class, 'storeGuest'])
        ->name('appointments.guest');
    
    Route::get('/appointment/confirmation/{id}', [AppointmentController::class, 'confirmation'])
        ->name('appointment.confirmation');

    Route::get('/api/patient/{patientId}', [AppointmentController::class, 'getPatientDetails']);

    // Patient Registration
    Route::get('/patients/register', [PatientController::class, 'showRegistrationForm'])
         ->name('patients.showRegister');
    Route::post('/patients/register', [PatientController::class, 'register'])
         ->name('patients.register');
    
    // Password Reset Routes
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
         ->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
         ->name('password.email');
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
         ->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])
         ->name('password.update');
});

// Authenticated User Routes (non-admin)
Route::middleware(['auth'])->group(function() {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    // Add any common authenticated user routes here
});

// Admin Routes
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Patients
        Route::resource('patients', AdminPatientController::class);
        Route::get('patients/{patient}/records', [AdminPatientController::class, 'records'])
            ->name('patients.records');
            
        // Notes
        Route::resource('patients.notes', NoteController::class)->shallow();
        Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
        
        // Records
        Route::get('records/create', [RecordController::class, 'create'])->name('records.create');
        
        // Appointments
        Route::resource('appointments', AppointmentController::class);
        Route::get('appointments/{id}/edit', [AppointmentController::class, 'edit'])
            ->name('appointments.edit');
        Route::patch('/appointments/{appointment}/complete', [AppointmentController::class, 'complete'])
            ->name('appointments.complete');
        Route::patch('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])
            ->name('appointments.cancel');
        
        // Treatments
        Route::resource('treatments', TreatmentController::class);
        
        // Payments
        Route::prefix('payments')->name('payments.')->group(function() {
            Route::get('/', [PaymentController::class, 'index'])->name('index');
            Route::get('/create/{appointment}', [PaymentController::class, 'create'])->name('create');
            Route::post('/', [PaymentController::class, 'store'])->name('store');
            Route::get('/{payment}/receipt', [PaymentController::class, 'receipt'])->name('receipt');
        });
        
        // Prescriptions
        Route::resource('prescriptions', PrescriptionController::class);
        
        // Reports
        Route::prefix('reports')->name('reports.')->group(function() {
            Route::get('/', [ReportController::class, 'index'])->name('index');
            Route::get('/financial', [ReportController::class, 'financial'])->name('financial');
            Route::get('/appointments', [ReportController::class, 'appointments'])->name('appointments');
        });
        
        // Inventory
        Route::prefix('inventory')->name('inventory.')->group(function() {
            Route::get('/', [InventoryController::class, 'index'])->name('index');
            Route::get('/create', [InventoryController::class, 'create'])->name('create');
            Route::post('/', [InventoryController::class, 'store'])->name('store');
            Route::get('/{item}/edit', [InventoryController::class, 'edit'])->name('edit');
            Route::put('/{item}', [InventoryController::class, 'update'])->name('update');
            
            // Stock Movements
            Route::get('/{item}/movements', [InventoryController::class, 'movements'])->name('movements');
            Route::get('/movements/create', [InventoryController::class, 'createMovement'])->name('movements.create');
            Route::post('/movements', [InventoryController::class, 'storeMovement'])->name('movements.store');
        });
    });