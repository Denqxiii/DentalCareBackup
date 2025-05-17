<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\InventoryItem;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        try {
            // Today's appointments count
            $todaysAppointments = Appointment::whereDate('appointment_date', today())->count();
            
            // Total patients count
            $totalPatients = Patient::count();
            
            // Monthly revenue (using payment_date column)
            $monthlyRevenue = Payment::whereMonth('payment_date', now()->month)
                                   ->sum('amount');
            
            // Low stock items
            $lowStockItems = InventoryItem::where('quantity', '<=', 5)->count();
            
            // Upcoming appointments (5 closest)
            $upcomingAppointments = Appointment::with('patient')
                ->whereDate('appointment_date', '>=', today())
                ->orderBy('appointment_date', 'asc')
                ->orderBy('appointment_time', 'asc')
                ->limit(5)
                ->get();
            
            // Recent payments (5 most recent)
            $recentPayments = Payment::with('patient')
                ->orderBy('payment_date', 'desc')
                ->limit(5)
                ->get();
            
            return view('admin.dashboard', compact(
                'todaysAppointments',
                'totalPatients',
                'monthlyRevenue',
                'lowStockItems',
                'upcomingAppointments',
                'recentPayments'
            ));
            
        } catch (\Exception $e) {
            return view('admin.dashboard', [
                'error' => $e->getMessage()
            ]);
        }
    }
}