<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\TreatmentRecord;
use App\Models\Appointment;
use App\Models\Invoice;
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
        // Validate request
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'report_type' => 'nullable|in:revenue,expenses,profit,collection'
        ]);

        // Set default date range if not provided
        $startDate = $request->input('start_date', now()->subMonth()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Calculate totals using correct column names
        $totalRevenue = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->where('status', 'Completed')
            ->sum('total_amount');

        $collectedAmount = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->where('status', 'Completed')
            ->sum('amount_paid');

        $outstandingAmount = $totalRevenue - $collectedAmount;

        // Update the revenue by treatment query
        $revenueByTreatment = Treatment::withCount(['appointments' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('appointment_date', [$startDate, $endDate])
                    ->where('status', 'Completed');
            }])
            ->withSum(['appointments' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('appointment_date', [$startDate, $endDate])
                    ->where('status', 'Completed');
            }], 'total_amount')
            ->withSum(['appointments' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('appointment_date', [$startDate, $endDate])
                    ->where('status', 'Completed');
            }], 'amount_paid')
            ->having('appointments_sum_total_amount', '>', 0)
            ->orderBy('appointments_sum_total_amount', 'desc')
            ->get();

        // Expenses by category
        try {
            $expensesByCategory = Expense::whereBetween('date', [$startDate, $endDate])
                ->selectRaw('category, sum(amount) as amount')
                ->groupBy('category')
                ->orderBy('amount', 'desc')
                ->get();
                
            $totalExpenses = $expensesByCategory->sum('amount');
            
            // Prepare data for chart
            $expenseCategories = $expensesByCategory->pluck('category')->toArray();
            $expenseAmounts = $expensesByCategory->pluck('amount')->toArray();
            
        } catch (\Exception $e) {
            // Handle case when expenses table doesn't exist or is empty
            $expensesByCategory = collect();
            $totalExpenses = 0;
            $expenseCategories = [];
            $expenseAmounts = [];
        }

        // Monthly revenue data for chart
        $monthlyRevenue = [];
        $currentDate = Carbon::parse($startDate);
        $endDateObj = Carbon::parse($endDate);

        while ($currentDate <= $endDateObj) {
            $month = $currentDate->format('M');
            $revenue = Appointment::whereMonth('appointment_date', $currentDate->month)
                ->whereYear('appointment_date', $currentDate->year)
                ->where('status', 'completed')
                ->sum('total_amount');

            $monthlyRevenue[$month] = $revenue;
            $currentDate->addMonth();
        }

        $reportType = $request->input('report_type', 'revenue');
        
        // Expense categories for chart
        $expenseCategories = $expensesByCategory->pluck('category')->toArray();
        $expenseAmounts = $expensesByCategory->pluck('amount')->toArray();

        return view('reports.financial', [
            'totalRevenue' => $totalRevenue,
            'collectedAmount' => $collectedAmount,
            'outstandingAmount' => $outstandingAmount,
            'totalExpenses' => $totalExpenses,
            'revenueByTreatment' => $revenueByTreatment,
            'expensesByCategory' => $expensesByCategory,
            'monthlyRevenue' => $monthlyRevenue,
            'expenseCategories' => $expenseCategories,
            'expenseAmounts' => $expenseAmounts,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'report_type' => $reportType
        ]);
    }
}