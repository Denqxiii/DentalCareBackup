<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\InvoiceRequest;
use App\Http\Requests\Admin\PaymentRequest;
use App\Models\Invoice;
use App\Models\Payment;
use App\Repositories\InvoiceRepository;
use PDF;

class BillingController extends BaseController
{
    private $invoiceRepository;

    public function __construct()
    {
        parent::__construct();
        $this->invoiceRepository = app(InvoiceRepository::class);
    }

    public function index()
    {
        $invoices = $this->invoiceRepository->getAllWithPaginate(15);
        
        $this->title = "Billing Management";
        $this->content = view('admin.billing.index', 
            compact('invoices'))->render();
            
        return $this->renderOutput();
    }

    public function create()
    {
        $patients = Patient::active()->get();
        $services = TreatmentType::billable()->get();
        
        $this->title = "Create New Invoice";
        $this->content = view('admin.billing.create', 
            compact('patients', 'services'))->render();
            
        return $this->renderOutput();
    }

    public function store(InvoiceRequest $request)
    {
        $data = $request->all();
        $invoice = $this->invoiceRepository->createInvoice($data);
        
        return redirect()
            ->route('admin.billing.show', $invoice->id)
            ->with(['success' => 'Invoice created successfully']);
    }

    public function show($id)
    {
        $invoice = $this->invoiceRepository->getEdit($id);
        $payments = $invoice->payments()->latest()->get();
        
        $this->title = "Invoice #" . $invoice->invoice_number;
        $this->content = view('admin.billing.show', 
            compact('invoice', 'payments'))->render();
            
        return $this->renderOutput();
    }

    public function edit($id)
    {
        $invoice = $this->invoiceRepository->getEdit($id);
        $patients = Patient::active()->get();
        $services = TreatmentType::billable()->get();
        
        $this->title = "Edit Invoice #" . $invoice->invoice_number;
        $this->content = view('admin.billing.edit', 
            compact('invoice', 'patients', 'services'))->render();
            
        return $this->renderOutput();
    }

    public function update(InvoiceRequest $request, $id)
    {
        $invoice = $this->invoiceRepository->getEdit($id);
        $data = $request->all();
        
        $this->invoiceRepository->updateInvoice($invoice, $data);
        
        return redirect()
            ->route('admin.billing.show', $invoice->id)
            ->with(['success' => 'Invoice updated successfully']);
    }

    public function destroy($id)
    {
        $invoice = $this->invoiceRepository->getEdit($id);
        $invoice->delete();
        
        return redirect()
            ->route('admin.billing.index')
            ->with(['success' => 'Invoice cancelled']);
    }
    
    public function createPayment($invoiceId)
    {
        $invoice = $this->invoiceRepository->getEdit($invoiceId);
        
        $this->title = "Record Payment for Invoice #" . $invoice->invoice_number;
        $this->content = view('admin.billing.create_payment', 
            compact('invoice'))->render();
            
        return $this->renderOutput();
    }
    
    public function storePayment(PaymentRequest $request, $invoiceId)
    {
        $invoice = $this->invoiceRepository->getEdit($invoiceId);
        $data = $request->all();
        
        $payment = $this->invoiceRepository->addPayment($invoice, $data);
        
        // Generate receipt
        $pdf = PDF::loadView('admin.billing.receipt', compact('payment', 'invoice'));
        
        return redirect()
            ->route('admin.billing.show', $invoice->id)
            ->with(['success' => 'Payment recorded successfully'])
            ->with('download', $pdf->download('receipt.pdf'));
    }
    
    public function printInvoice($id)
    {
        $invoice = $this->invoiceRepository->getEdit($id);
        $pdf = PDF::loadView('admin.billing.invoice_pdf', compact('invoice'));
        
        return $pdf->stream('invoice_' . $invoice->invoice_number . '.pdf');
    }
    
    public function reports()
    {
        $this->title = "Financial Reports";
        $this->content = view('admin.billing.reports')->render();
        return $this->renderOutput();
    }
    
    public function generateReport(Request $request)
    {
        $validated = $request->validate([
            'report_type' => 'required|in:revenue,outstanding,payments',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        
        $report = $this->invoiceRepository->generateReport(
            $validated['report_type'],
            $validated['start_date'],
            $validated['end_date']
        );
        
        if ($request->has('export')) {
            return Excel::download(
                new FinancialReportExport($report), 
                $validated['report_type'] . '_report.xlsx'
            );
        }
        
        $this->title = ucfirst($validated['report_type']) . " Report";
        $this->content = view('admin.billing.report_results', 
            compact('report', 'validated'))->render();
            
        return $this->renderOutput();
    }
}