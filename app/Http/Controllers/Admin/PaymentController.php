<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;  
use App\Models\Appointment;

class PaymentController extends Controller
{
    public function index()
    {
        // Get completed appointments that are unpaid
        $appointments = Appointment::where('status', 'completed')
            ->whereDoesntHave('payment')  // no payment recorded yet
            ->with('patient')             // eager load patient info
            ->paginate(15);

        return view('admin.payments.index', compact('appointments'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|string',
            'payment_date' => 'required|date',
        ]);

        $appointment = Appointment::findOrFail($data['appointment_id']);

        // Create payment record (you might want to link this to an invoice if you have one)
        $payment = new Payment();
        $payment->appointment_id = $appointment->id;
        $payment->amount = $data['amount'];
        $payment->method = $data['method'];
        $payment->created_at = $data['payment_date'];
        $payment->save();

        // Mark appointment as paid (or update invoice status)
        $appointment->status = 'paid';  // or a new column like 'payment_status'
        $appointment->save();

        return redirect()->route('payments.index')->with('success', 'Payment recorded successfully!');
    }

    public function create(Appointment $appointment)
    {
        // Add any authorization checks if needed
        if (!$appointment->invoice) {
            abort(404, 'Invoice not found for this appointment');
        }

        return view('admin.payments.create', [
            'appointment' => $appointment,
            'invoice' => $appointment->invoice
        ]);
    }
}
