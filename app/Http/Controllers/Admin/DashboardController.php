<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\InventoryItem;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with summary information.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            // Get today's date
            $today = Carbon::today();
            
            // Today's appointments
            $todaysAppointments = Appointment::whereDate('date', $today)->count();
            
            // Total patients
            $totalPatients = Patient::count();
            
            // Monthly revenue
            $monthStart = Carbon::now()->startOfMonth();
            $monthEnd = Carbon::now()->endOfMonth();
            
            $monthlyRevenue = Payment::whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('amount');
            
            // Format monthly revenue as currency
            $monthlyRevenue = '$' . number_format($monthlyRevenue, 2);
            
            // Low stock items
            $lowStockItems = InventoryItem::where('quantity', '<=', 'min_stock_level')->count();
            
            // Upcoming appointments (next 7 days)
            $nextWeek = Carbon::today()->addDays(7);
            $upcomingAppointments = Appointment::with('patient')
                ->whereBetween('date', [$today, $nextWeek])
                ->orderBy('date')
                ->orderBy('time')
                ->take(5)
                ->get();
            
            // Recent payments
            $recentPayments = Payment::with('patient')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            
            return view('dashboard', compact(
                'todaysAppointments',
                'totalPatients',
                'monthlyRevenue',
                'lowStockItems',
                'upcomingAppointments',
                'recentPayments'
            ));
            
        } catch (\Exception $e) {
            // If there's an error (like missing model classes), display error message
            return view('dashboard', ['error' => $e->getMessage()]);
        }
    }
}