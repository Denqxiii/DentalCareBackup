<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\TreatmentRecord;
use App\Models\Appointment;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; // For exporting to Excel (if you want Excel support)
use Barryvdh\DomPDF\Facade as PDF; // For generating PDFs (if you want PDF support)

class ReportController extends Controller
{
    // Method for generating patient history report
    public function generatePatientHistory()
    {
        // Get patient data, treatments, appointments, etc.
        $patients = Patient::with(['treatments', 'appointments'])->get();

        // Return a view with the patient data for a formatted report
        return view('reports.patient_history', compact('patients'));
    }

    // Method for generating treatment records report
    public function generateTreatmentReport()
    {
        $treatments = TreatmentRecord::all();
        return view('reports.treatment_report', compact('treatments'));
    }

    // Example for generating a PDF report (requires barryvdh/laravel-dompdf)
    public function generatePdfReport()
    {
        $patients = Patient::all();
        $pdf = PDF::loadView('reports.patient_pdf', compact('patients'));

        return $pdf->download('patient_report.pdf');
    }

    // Example for generating an Excel report (requires maatwebsite/excel)
    public function generateExcelReport()
    {
        $patients = Patient::all();
        return Excel::download(new PatientsExport($patients), 'patients_report.xlsx');
    }

    // Generate a billing report
    public function billingReport()
    {
        $invoices = Invoice::with('payments')->get();
        $totalRevenue = $invoices->where('status', 'Paid')->sum('total_amount');
        $outstandingBalance = $invoices->where('status', '!=', 'Paid')->sum('balance');

        return view('reports.billing', compact('invoices', 'totalRevenue', 'outstandingBalance'));
    }

    public function financial()
    {
        // Add your report logic here
        return view('reports.financial'); 
    }
}
