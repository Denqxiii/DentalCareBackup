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
        return view('payments.create', compact('bill'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Bill $bill)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . ($bill->total_amount - $bill->paid_amount),
            'payment_method' => 'required|string',
        ]);

        Payment::create([
            'bill_id' => $bill->id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
        ]);

        $bill->update([
            'paid_amount' => $bill->paid_amount + $request->amount,
            'status' => $bill->total_amount == ($bill->paid_amount + $request->amount) ? 'Paid' : 'Partial',
        ]);

        return redirect()->route('bills.show', $bill)->with('success', 'Payment recorded successfully!');
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
