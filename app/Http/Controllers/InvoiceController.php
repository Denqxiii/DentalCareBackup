<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    /**
     * Display a listing of invoices.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Invoice::with('patient');

        // Filter by patient if selected
        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        // Filter by status if selected
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range if selected
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        // Get all patients for filter dropdown
        $patients = Patient::select('id as patient_id', 'first_name', 'last_name')
                        ->orderBy('last_name')
                        ->get();

        $bills = $query->latest()->paginate(10);

        return view('billing.invoices.index', compact('bills', 'patients'));
    }

    /**
     * Show the form for creating a new invoice.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $patients = Patient::orderBy('last_name')->get();
        return view('billing.invoices.create', compact('patients'));
    }

    /**
     * Store a newly created invoice in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        // Create new invoice with default status 'pending'
        $invoice = new Invoice();
        $invoice->patient_id = $request->patient_id;
        $invoice->appointment_id = $request->appointment_id;
        $invoice->total_amount = $request->total_amount;
        $invoice->notes = $request->notes;
        $invoice->status = 'pending';
        $invoice->due_date = Carbon::now()->addDays(30); // Set due date as 30 days from now
        $invoice->save();

        // If this invoice is tied to an appointment, you might want to update the appointment
        if ($request->appointment_id) {
            $appointment = Appointment::find($request->appointment_id);
            $appointment->billing_status = 'billed';
            $appointment->save();
        }

        return redirect()->route('billing.invoices.show', $invoice->id)
            ->with('success', 'Bill created successfully.');
    }

    /**
     * Display the specified invoice.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        // Load the invoice with related patient and appointment
        $bill = $invoice->load(['patient', 'appointment', 'payments']);
        
        return view('billing.invoices.show', compact('bill'));
    }

    /**
     * Show the form for editing the specified invoice.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        $patients = Patient::orderBy('last_name')->get();
        $bill = $invoice->load(['patient', 'appointment']);
        
        // Get appointments for the patient
        $appointments = [];
        if ($bill->patient_id) {
            $appointments = Appointment::where('patient_id', $bill->patient_id)->get();
        }
        
        return view('billing.invoices.edit', compact('bill', 'patients', 'appointments'));
    }

    /**
     * Update the specified invoice in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,paid,overdue',
            'notes' => 'nullable|string|max:500',
        ]);

        // Update invoice
        $invoice->patient_id = $request->patient_id;
        $invoice->appointment_id = $request->appointment_id;
        $invoice->total_amount = $request->total_amount;
        $invoice->status = $request->status;
        $invoice->notes = $request->notes;
        
        // Update due date if provided
        if ($request->filled('due_date')) {
            $invoice->due_date = $request->due_date;
        }
        
        $invoice->save();

        return redirect()->route('billing.invoices.show', $invoice->id)
            ->with('success', 'Bill updated successfully.');
    }

    /**
     * Remove the specified invoice from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        // Check if the invoice has any payments
        if ($invoice->payments()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete bill with recorded payments. Delete payments first.');
        }
        
        // Delete the invoice
        $invoice->delete();

        return redirect()->route('billing.invoices.index')
            ->with('success', 'Bill deleted successfully.');
    }

    /**
     * Get appointments for a specific patient (AJAX endpoint)
     * 
     * @param int $patientId
     * @return \Illuminate\Http\Response
     */
    public function getAppointments($patientId)
    {
        $appointments = Appointment::where('patient_id', $patientId)
            ->orderBy('appointment_date', 'desc')
            ->get(['id', 'treatment_type', 'appointment_date']);
            
        return response()->json($appointments);
    }
}