<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Patient;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // List all payments
    public function index()
    {
        $payments = Payment::with(['patient', 'appointment'])
                        ->latest()
                        ->paginate(10);
                        
        return view('billing.payments.index', compact('payments'));
    }

    // Show form to create a new payment
    public function create(Appointment $appointment)
    {
        return view('payments.create', [
            'appointment' => $appointment,
            'invoice' => $appointment->invoice
        ]);
    }

    /**
     * Store a general payment
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'invoice_id' => 'nullable|exists:invoices,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|in:cash,credit_card,debit_card,bank_transfer,insurance',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        // Set status as completed by default for most payments
        $status = 'completed';
        
        $payment = Payment::create([
            'patient_id' => $validated['patient_id'],
            'invoice_id' => $validated['invoice_id'] ?? null,
            'amount' => $validated['amount'],
            'payment_date' => $validated['payment_date'],
            'payment_method' => $validated['payment_method'],
            'reference_number' => $validated['reference_number'] ?? null,
            'status' => $status,
            'notes' => $validated['notes'] ?? null
        ]);

        // If payment is linked to an invoice, update the invoice status
        if ($payment->invoice_id) {
            $invoice = Invoice::find($payment->invoice_id);
            $this->updateInvoiceStatus($invoice, $payment->amount);
            
            // Redirect to receipt page with relevant data
            return redirect()->route('receipts.preview', $payment->id)
                ->with('success', 'Payment recorded successfully!');
        }

        return redirect()->route('billing.payments.index')
            ->with('success', 'Payment created successfully');
    }

    /**
     * Show payment form for a specific bill/invoice
     */
    public function createForBill(Invoice $bill)
    {
        $patient = Patient::find($bill->patient_id);
        return view('billing.payments.create-for-bill', compact('bill', 'patient'));
    }

    /**
     * Store a payment for a specific bill/invoice
     */
    public function storeForBill(Request $request, Invoice $bill)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $bill->balance,
            'payment_method' => 'required|string|in:cash,credit_card,debit_card,bank_transfer,insurance',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        // Create the payment record
        $payment = Payment::create([
            'invoice_id' => $bill->id,
            'patient_id' => $bill->patient_id,
            'amount' => $validated['amount'],
            'payment_date' => now(),
            'payment_method' => $validated['payment_method'],
            'reference_number' => $validated['reference_number'] ?? null,
            'status' => 'completed',
            'notes' => $validated['notes'] ?? null
        ]);

        // Update the invoice status
        $this->updateInvoiceStatus($bill, $validated['amount']);

        // Get the patient for the receipt page
        $patient = Patient::find($bill->patient_id);

        // Store data in session for the receipt page
        session([
            'payment' => $payment,
            'bill' => $bill,
            'patient' => $patient
        ]);

        return redirect()->route('receipts.preview', $payment->id)
            ->with('success', 'Payment recorded successfully!');
    }

    /**
     * Show a payment
     */
    public function show(Payment $payment)
    {
        $payment->load(['patient', 'invoice']);
        return view('billing.payments.show', compact('payment'));
    }

    /**
     * Edit a payment
     */
    public function edit(Payment $payment)
    {
        $patients = Patient::orderBy('last_name')->orderBy('first_name')->get();
        $invoices = Invoice::where('status', '!=', 'paid')
            ->orWhere('id', $payment->invoice_id)  // Include current invoice even if paid
            ->get();
            
        return view('billing.payments.edit', compact('payment', 'patients', 'invoices'));
    }

    /**
     * Update a payment
     */
    public function update(Request $request, Payment $payment)
    {
        // First, if this payment was previously applied to an invoice,
        // we need to restore the invoice's previous balance
        if ($payment->invoice_id) {
            $oldInvoice = Invoice::find($payment->invoice_id);
            if ($oldInvoice) {
                // Add the payment amount back to the balance
                $oldInvoice->balance += $payment->amount;
                $oldInvoice->paid_amount -= $payment->amount;
                
                // Update status based on the new balance
                if ($oldInvoice->balance >= $oldInvoice->total_amount) {
                    $oldInvoice->status = 'unpaid';
                } elseif ($oldInvoice->balance > 0) {
                    $oldInvoice->status = 'partially_paid';
                } else {
                    $oldInvoice->status = 'paid';
                }
                
                $oldInvoice->save();
            }
        }

        // Validate the updated payment data
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'invoice_id' => 'nullable|exists:invoices,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|in:cash,credit_card,debit_card,bank_transfer,insurance',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        // Update the payment
        $payment->update([
            'patient_id' => $validated['patient_id'],
            'invoice_id' => $validated['invoice_id'] ?? null,
            'amount' => $validated['amount'],
            'payment_date' => $validated['payment_date'],
            'payment_method' => $validated['payment_method'],
            'reference_number' => $validated['reference_number'] ?? null,
            'notes' => $validated['notes'] ?? null
        ]);

        // If the payment is now linked to an invoice, update that invoice's status
        if ($payment->invoice_id) {
            $newInvoice = Invoice::find($payment->invoice_id);
            $this->updateInvoiceStatus($newInvoice, $payment->amount);
        }

        return redirect()->route('billing.payments.index')
            ->with('success', 'Payment updated successfully');
    }

    /**
     * Delete a payment
     */
    public function destroy(Payment $payment)
    {
        // If payment was applied to an invoice, restore the invoice's previous balance
        if ($payment->invoice_id) {
            $invoice = Invoice::find($payment->invoice_id);
            if ($invoice) {
                // Add the payment amount back to the balance
                $invoice->balance += $payment->amount;
                $invoice->paid_amount -= $payment->amount;
                
                // Update status based on the new balance
                if ($invoice->balance >= $invoice->total_amount) {
                    $invoice->status = 'unpaid';
                } elseif ($invoice->balance > 0) {
                    $invoice->status = 'partially_paid';
                } else {
                    $invoice->status = 'paid';
                }
                
                $invoice->save();
            }
        }

        // Delete the payment
        $payment->delete();

        return redirect()->route('billing.payments.index')
            ->with('success', 'Payment deleted successfully');
    }

    /**
     * Update invoice status when a payment is made
     */
    protected function updateInvoiceStatus(Invoice $invoice, $paymentAmount)
    {
        // Deduct payment from balance
        $invoice->balance = max(0, $invoice->balance - $paymentAmount);
        $invoice->paid_amount += $paymentAmount;
        
        // Update status based on new balance
        if ($invoice->balance <= 0) {
            $invoice->status = 'paid';
        } else {
            $invoice->status = 'partially_paid';
        }
        
        $invoice->save();
        
        return $invoice;
    }
}