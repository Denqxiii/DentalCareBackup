<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    // List all bills
    public function index(Request $request)
    {
        $query = Bill::with('patient');
        
        // Only filter if patient_id exists and is not empty
        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }
        
        $bills = $query->latest()->paginate(10);
        $patients = Patient::orderBy('last_name')->orderBy('first_name')->get();
        
        return view('billing.bills.index', compact('bills', 'patients'));
    }

    // Show the form to create a new bill
    public function create()
    {
        $patients = Patient::orderBy('last_name')->orderBy('first_name')->get();
        
        return view('billing.bills.create', compact('patients'));
    }

    // Store a new bill
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'total_amount' => 'required|numeric|min:0.01',
            'amount_paid' => 'required|numeric|min:0',
        ]);

        // Calculate balance
        $totalAmount = $request->total_amount;
        $paidAmount = $request->amount_paid;
        $balance = max(0, $totalAmount - $paidAmount);
        
        // Determine status based on balance
        $status = $balance <= 0 ? 'paid' : 'partially_paid';
        
        // If paid amount is 0, set status to unpaid
        if ($paidAmount <= 0) {
            $status = 'unpaid';
        }

        // Create the invoice
        $invoice = Invoice::create([
            'bill_number' => 'BILL-' . time(),
            'patient_id' => $request->patient_id,
            'appointment_id' => $request->appointment_id,
            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'balance' => $balance,
            'status' => $status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('billing.invoices')->with('success', 'Bill created successfully!');
    }

    // Show details of a specific bill
    public function show(Invoice $bill)
    {
        return view('billing.bills.show', compact('bill'));
    }
}