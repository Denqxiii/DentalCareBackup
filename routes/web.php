<?php

use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\TreatmentRecordController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('homepage');
})->name('homepage');

Route::get('/book-appointment', function () {
    return view('book_appointment');
})->name('book.appointment'); 

Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');

Route::get('/reports/patient-history', [ReportController::class, 'generatePatientHistory'])->name('reports.patient_history');
Route::get('/reports/treatment-report', [ReportController::class, 'generateTreatmentReport'])->name('reports.treatment_report');
Route::get('/reports/treatments', [TreatmentRecordController::class, 'showReport'])->name('reports.treatments');

Route::get('/api/patient-details/{id}', [PatientController::class, 'fetchPatientDetails']);
Route::get('/book-appointment', [AppointmentController::class, 'create'])->name('book.appointment');
Route::post('/book-appointment', [AppointmentController::class, 'store'])->name('appointment.store');
Route::get('/patient-details/{id}', [AppointmentController::class, 'getPatientDetails'])->name('appointment.patient.details');


// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/admin', function () {
        return view('dashboard');
    });

    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/charts', function () {
        return view('charts');
    })->name('charts');

    Route::get('/services', function () {
        return view('services');
    })->name('services');
    
    // Patient routes
    Route::get('/register_patients', function () {
        return view('register_patients');
    })->name('register_patients');   

    // List of registered patients
    Route::get('/registered_patients', [PatientController::class, 'index'])->name('patients.index');
    // Show patient details
    Route::get('/patients/{patient_id}', [PatientController::class, 'show'])->name('patients.show_details');
    // Edit patient
    Route::get('/patients/{patient_id}/edit', [PatientController::class, 'edit'])->name('patients.edit_patient');
    // Update patient
    Route::put('/patients/{patient_id}', [PatientController::class, 'update'])->name('patients.update');
    
    // Treatment records routes
    Route::get('/patients/{patient_id}/treatments/create', [TreatmentRecordController::class, 'create'])->name('treatments.create');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('appointments', AppointmentController::class);
    });
    Route::get('/admin/appointments/{id}/manage', [App\Http\Controllers\AppointmentController::class, 'manage'])->name('admin.appointments.manage');

    // Inventory List
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::resource('inventory', InventoryController::class);
    Route::resource('stock-movements', StockMovementController::class);
    

    // Billing routes
    Route::resource('bills', BillController::class);
    Route::get('bills/{bill}/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('bills/{bill}/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::delete('payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');

    // Report routes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/patients/history', [PatientController::class, 'history'])->name('patients.history');
});

require __DIR__.'/auth.php';
