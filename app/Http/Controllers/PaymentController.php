<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with(['bill.patient'])
            ->latest()
            ->paginate(10);
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Bill $bill)
    {
        if ($bill->status === 'paid') {
            return redirect()->route('bills.show', $bill)
                ->with('error', 'This bill is already fully paid.');
        }

        return view('payments.create', compact('bill'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Bill $bill)
    {
        if ($bill->status === 'paid') {
            return redirect()->route('bills.show', $bill)
                ->with('error', 'This bill is already fully paid.');
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $bill->balance,
            'payment_method' => 'required|in:cash,credit_card,debit_card,bank_transfer,insurance',
            'reference_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            $payment = Payment::create([
                'bill_id' => $bill->id,
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'reference_number' => $validated['reference_number'],
                'notes' => $validated['notes']
            ]);

            DB::commit();
            return redirect()->route('bills.show', $bill)
                ->with('success', 'Payment recorded successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error recording payment: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment->load(['bill.patient']);
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $bill = $payment->bill;

        DB::beginTransaction();
        try {
            // Reverse the payment's effect on the bill
            $bill->paid_amount -= $payment->amount;
            $bill->balance = $bill->total_amount - $bill->paid_amount;
            $bill->updateStatus();
            
            $payment->delete();
            
            DB::commit();
            return redirect()->route('bills.show', $bill)
                ->with('success', 'Payment deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting payment: ' . $e->getMessage());
        }
    }
}
