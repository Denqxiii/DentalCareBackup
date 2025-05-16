<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Show the form for creating a new payment.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function create(Invoice $invoice)
    {
        $bill = $invoice;
        return view('billing.payments.create', compact('bill'));
    }

    /**
     * Store a newly created payment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $invoice->balance,
            'payment_method' => 'required|in:cash,card,bank_transfer,insurance',
            'reference_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            // Create the payment
            $payment = new Payment();
            $payment->invoice_id = $invoice->id;
            $payment->amount = $request->amount;
            $payment->payment_method = $request->payment_method;
            $payment->reference_number = $request->reference_number;
            $payment->payment_number = Payment::generatePaymentNumber();
            $payment->notes = $request->notes;
            $payment->save();

            // Update the invoice's paid amount
            $invoice->paid_amount = $invoice->paid_amount + $request->amount;
            
            // Update invoice status
            if ($invoice->paid_amount >= $invoice->total_amount) {
                $invoice->status = 'paid';
            } else if ($invoice->paid_amount > 0) {
                $invoice->status = 'partial';
            }
            
            $invoice->save();

            DB::commit();
            
            return redirect()->route('billing.invoices.show', $invoice->id)
                ->with('success', 'Payment recorded successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'An error occurred while recording the payment: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified payment from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        DB::beginTransaction();
        try {
            $invoice = $payment->invoice;
            
            // Subtract the payment amount from the invoice's paid amount
            $invoice->paid_amount = $invoice->paid_amount - $payment->amount;
            
            // Update the invoice status
            if ($invoice->paid_amount <= 0) {
                $invoice->paid_amount = 0;
                $invoice->status = 'pending';
                
                // Check if invoice is overdue
                if ($invoice->due_date < now()) {
                    $invoice->status = 'overdue';
                }
            } else if ($invoice->paid_amount < $invoice->total_amount) {
                $invoice->status = 'partial';
            }
            
            $invoice->save();
            
            // Delete the payment
            $payment->delete();
            
            DB::commit();
            
            return redirect()->route('billing.invoices.show', $invoice->id)
                ->with('success', 'Payment deleted successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'An error occurred while deleting the payment: ' . $e->getMessage());
        }
    }
}