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
        $patients = Patient::all();
        $appointments = Appointment::with('patient')->get();

        return view('billing.bills.create', compact('patients'));
    }

    // Store a new bill
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id', // Optional field
            'total_amount' => 'required|numeric|min:0.01',
        ]);

        Invoice::create([
            'bill_number' => 'BILL-' . time(),
            'patient_id' => $request->patient_id,
            'appointment_id' => $request->appointment_id, // Can be null
            'total_amount' => $request->total_amount,
            'paid_amount' => 0,
            'balance' => $request->total_amount,
            'status' => 'unpaid',
            'notes' => $request->notes,
        ]);

        return redirect()->route('billing.invoices');
    }

    // Show details of a specific bill
    public function show(Invoice $bill)
    {
        return view('bills.show', compact('bill'));
    }
}
