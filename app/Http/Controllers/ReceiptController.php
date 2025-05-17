<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ReceiptController extends Controller
{
    /**
     * Preview the receipt for a payment
     */
    public function preview(Payment $payment)
    {
        // Load related models
        $payment->load(['patient', 'invoice']);
        
        // Get needed data
        $bill = $payment->invoice;
        $patient = $payment->patient;
        
        return view('billing.receipts.preview', compact('payment', 'bill', 'patient'));
    }
    
    /**
     * Generate a downloadable PDF receipt
     */
    public function download(Payment $payment)
    {
        // Load related models
        $payment->load(['patient', 'invoice']);
        
        // Get needed data
        $bill = $payment->invoice;
        $patient = $payment->patient;
        
        // Generate the receipt view
        $view = View::make('billing.receipts.pdf', compact('payment', 'bill', 'patient'));
        
        // If you're using a PDF library like DomPDF, you'd generate PDF here
        // For now, we'll just show a view that could be printed
        return view('billing.receipts.download', compact('payment', 'bill', 'patient'));
    }
    
    /**
     * Generate a receipt (alias for download)
     */
    public function generate(Payment $payment)
    {
        return $this->download($payment);
    }
}