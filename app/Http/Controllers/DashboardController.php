<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\TreatmentRecord;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Total Patients
        $totalPatients = Patient::count();
        $patientsLastMonth = Patient::whereBetween('created_at', [now()->subMonth(), now()])->count();
        $patientsPrevMonth = Patient::whereBetween('created_at', [now()->subMonths(2), now()->subMonth()])->count();
        $patientsPercent = $patientsPrevMonth > 0
            ? round((($patientsLastMonth - $patientsPrevMonth) / $patientsPrevMonth) * 100)
            : 100;

        // Total Appointments
        $totalAppointments = Appointment::count();
        $appointmentsThisMonth = Appointment::whereMonth('created_at', now()->month)->count();
        $appointmentsLastMonth = Appointment::whereMonth('created_at', now()->subMonth()->month)->count();
        $appointmentsPercent = $appointmentsLastMonth > 0
            ? round((($appointmentsThisMonth - $appointmentsLastMonth) / $appointmentsLastMonth) * 100)
            : 100;

        // Completed Treatments
        $completedTreatments = TreatmentRecord::where('status', 'completed')->count();
        $completedThisMonth = TreatmentRecord::where('status', 'completed')->whereMonth('created_at', now()->month)->count();
        $completedLastMonth = TreatmentRecord::where('status', 'completed')->whereMonth('created_at', now()->subMonth()->month)->count();
        $completedPercent = $completedLastMonth > 0
            ? round((($completedThisMonth - $completedLastMonth) / $completedLastMonth) * 100)
            : 100;

        // New Patients
        $newPatients = Patient::whereMonth('created_at', now()->month)->count();
        $newPatientsLastMonth = Patient::whereMonth('created_at', now()->subMonth()->month)->count();
        $newPatientsPercent = $newPatientsLastMonth > 0
            ? round((($newPatients - $newPatientsLastMonth) / $newPatientsLastMonth) * 100)
            : 100;

        // Upcoming Appointment
        $upcomingAppointments = Appointment::with('patient')->where('appointment_date', '>=', now())
            ->orderBy('appointment_date', 'asc')
            ->take(5)
            ->get();

        // Recent Activity Notifications (replace with dynamic DB queries as needed)
        $recentActivities = [
            ['message' => 'New patient registered: John Doe', 'timestamp' => now()->subMinutes(10)],
            ['message' => 'Appointment completed for Jane Smith', 'timestamp' => now()->subHour()],
        ];

        return view('dashboard', compact(
            'totalPatients',
            'totalAppointments',
            'completedTreatments',
            'newPatients',
            'patientsPercent',
            'appointmentsPercent',
            'completedPercent',
            'newPatientsPercent',
            'upcomingAppointments',
            'recentActivities'
        ));
    }
}
