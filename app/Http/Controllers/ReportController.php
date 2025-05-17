<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\TreatmentRecord;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Treatment; 
use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel; // For exporting to Excel (if you want Excel support)
use Barryvdh\DomPDF\Facade as PDF; // For generating PDFs (if you want PDF support)

class ReportController extends Controller
{
    public function financial(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));
        $reportType = $request->input('report_type', 'revenue');

        // Get completed appointments in date range
        $appointments = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->where('status', 'Completed')
            ->get();

        // Calculate totals - use the correct column name (e.g., 'amount' instead of 'total_amount')
        $totalRevenue = $appointments->sum('amount'); // Change 'amount' to your actual column name
        $collectedAmount = Payment::whereBetween('payment_date', [$startDate, $endDate])->sum('amount');
        $outstandingAmount = $totalRevenue - $collectedAmount;

        // Get revenue by treatment type
        $revenueByTreatment = Appointment::selectRaw('
                treatments.name,
                COUNT(appointments.id) as patient_count,
                SUM(treatments.price) as total_revenue,  // Get price from treatments
                SUM(payments.amount) as collected_amount
            ')
            ->join('treatments', 'appointments.treatment_id', '=', 'treatments.id')
            ->leftJoin('payments', 'appointments.id', '=', 'payments.appointment_id')
            ->whereBetween('appointment_date', [$startDate, $endDate])
            ->where('appointments.status', 'Completed')
            ->groupBy('treatments.name')
            ->get();

        // Get expenses by category
        $expensesByCategory = Expense::selectRaw('
                category,
                SUM(amount) as amount
            ')
            ->whereBetween('expense_date', [$startDate, $endDate])
            ->groupBy('category')
            ->get();

        $totalExpenses = $expensesByCategory->sum('amount');

        return view('financial', compact(
            'startDate',
            'endDate',
            'reportType',
            'totalRevenue',
            'collectedAmount',
            'outstandingAmount',
            'revenueByTreatment',
            'expensesByCategory',
            'totalExpenses'
        ));
    }
}