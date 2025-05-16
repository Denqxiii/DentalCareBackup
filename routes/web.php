<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    PatientController,
    AppointmentController,
    TreatmentRecordController,
    InventoryController,
    StockMovementController,
    ReportController,
    BillController,
    PaymentController,
    DashboardController,
    SupplierController,
    PrescriptionController
};

// Public Routes
Route::get('/', function () {
    return view('homepage');
})->name('homepage');

Route::get('/patients/register', function () {
    return view('register_patients');
})->name('register_patients');

// Appointment Booking (Public)
Route::controller(AppointmentController::class)->group(function () {
    Route::get('/book-appointment', 'create')->name('book.appointment');
    Route::post('/book-appointment', 'store')->name('appointment.store');
});

// Patient Registration (Public)
Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');

// API Routes
Route::prefix('api')->group(function () {
    // Patient details from PatientController
    Route::get('/patients/{id}', [PatientController::class, 'fetchPatientDetails'])
         ->name('patient.details');
         
    // Patient details specific to appointments
    Route::get('/appointments/patient/{id}', [AppointmentController::class, 'getPatientDetails'])
         ->name('appointment.patient.details');
         
    Route::get('/appointments/{patient_id}', [AppointmentController::class, 'getAppointments'])
         ->name('appointments.get');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/admin', function () {
        return redirect()->route('dashboard');
    })->name('admin');

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Patient Routes
    Route::controller(PatientController::class)->group(function () {
        Route::get('/patients', [PatientController::class, 'index'])->name('patient.index');
        Route::get('/patients/{patient}', [PatientController::class, 'showDetails'])->name('patients.show_details');
        Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
        Route::get('/patients/{patient_id}/edit', 'edit')->name('patients.edit_patient');
        Route::put('/patients/{patient_id}', 'update')->name('patients.update');
        Route::get('/patients/history', 'history')->name('patients.history');
    });

    // Treatment Records
    Route::get('/patients/{patient_id}/treatments/create', [TreatmentRecordController::class, 'create'])
         ->name('treatments.create');

    // Appointments Management
    Route::patch('/appointments/{appointment}/update-status', [AppointmentController::class, 'updateStatus'])
        ->name('admin.appointments.update-status');
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])
        ->name('admin.appointments.show');

    // Admin Group
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('appointments', AppointmentController::class);
        Route::get('appointments/{id}/manage', [AppointmentController::class, 'manage'])
             ->name('appointments.manage');
    });

    // Inventory Management
    Route::controller(InventoryController::class)->group(function () {
        Route::get('/inventory', 'index')->name('inventory.index');
        Route::get('/inventory/create', 'create')->name('inventory.create');
        Route::post('/inventory', 'store')->name('inventory.store');
    });
    Route::resource('inventory', InventoryController::class);
    Route::resource('stock-movements', StockMovementController::class);

    // Billing Routes Group
    Route::prefix('billing')->name('billing.')->group(function() {
        
        // Bills - Full resource controller
        Route::resource('bills', BillController::class)->names([
            'index' => 'invoices',
            'create' => 'invoices.create',
            'store' => 'invoices.store',
            // ...
        ]);
        
        // Payments - Full resource controller
        Route::resource('payments', PaymentController::class);
        
        // Special payment creation that requires a bill
        Route::get('bills/{bill}/payments/create', [PaymentController::class, 'create'])
            ->name('payments.create');
        
        // Additional generic payments route if needed
        Route::get('payments', [PaymentController::class, 'index'])
            ->name('payments'); // This creates billing.payments
    });

    // Reports
    Route::controller(ReportController::class)->group(function () {
        Route::get('/reports', 'index')->name('reports.index');
        Route::get('/reports/patient-history', 'generatePatientHistory')->name('reports.patient');
        Route::get('/reports/treatment-report', 'generateTreatmentReport')->name('reports.treatment_report');
        Route::get('/reports/treatments', 'showReport')->name('reports.treatment');
        Route::get('/reports/billing', 'billingReport')->name('reports.billing');
        Route::get('/reports/financial', 'financial')->name('reports.financial'); // Fixed this line
    });

    //Prescription Management
    Route::resource('prescriptions', 'App\Http\Controllers\PrescriptionController');
});

require __DIR__.'/auth.php';