<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bills = Bill::with(['patient', 'appointment'])
            ->latest()
            ->paginate(10);
        return view('bills.index', compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::all();
        $appointments = Appointment::whereDoesntHave('bill')->get();
        return view('bills.create', compact('patients', 'appointments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,patient_id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'due_date' => 'required|date|after_or_equal:today'
        ]);

        DB::beginTransaction();
        try {
            $bill = Bill::create([
                'patient_id' => $validated['patient_id'],
                'appointment_id' => $validated['appointment_id'],
                'total_amount' => $validated['total_amount'],
                'balance' => $validated['total_amount'],
                'notes' => $validated['notes'],
                'due_date' => $validated['due_date']
            ]);

            DB::commit();
            return redirect()->route('bills.show', $bill)
                ->with('success', 'Bill created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating bill: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Bill $bill)
    {
        $bill->load(['patient', 'appointment', 'payments']);
        return view('bills.show', compact('bill'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bill $bill)
    {
        if ($bill->status === 'paid') {
            return redirect()->route('bills.show', $bill)
                ->with('error', 'Cannot edit a paid bill.');
        }

        $patients = Patient::all();
        $appointments = Appointment::whereDoesntHave('bill')
            ->orWhere('id', $bill->appointment_id)
            ->get();
        return view('bills.edit', compact('bill', 'patients', 'appointments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bill $bill)
    {
        if ($bill->status === 'paid') {
            return redirect()->route('bills.show', $bill)
                ->with('error', 'Cannot update a paid bill.');
        }

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,patient_id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'due_date' => 'required|date'
        ]);

        DB::beginTransaction();
        try {
            $bill->update([
                'patient_id' => $validated['patient_id'],
                'appointment_id' => $validated['appointment_id'],
                'total_amount' => $validated['total_amount'],
                'balance' => $validated['total_amount'] - $bill->paid_amount,
                'notes' => $validated['notes'],
                'due_date' => $validated['due_date']
            ]);

            $bill->updateStatus();
            DB::commit();

            return redirect()->route('bills.show', $bill)
                ->with('success', 'Bill updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating bill: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill)
    {
        if ($bill->status === 'paid') {
            return redirect()->route('bills.show', $bill)
                ->with('error', 'Cannot delete a paid bill.');
        }

        DB::beginTransaction();
        try {
            $bill->delete();
            DB::commit();
            return redirect()->route('bills.index')
                ->with('success', 'Bill deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting bill: ' . $e->getMessage());
        }
    }
}
