<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AppointmentsExport;
use App\Exports\FinancialReportExport;
use App\Exports\PatientsExport;
use App\Exports\TreatmentsExport;
use App\Repositories\ReportRepository;
use Illuminate\Http\Request;

class ReportController extends BaseController
{
    private $reportRepository;

    public function __construct()
    {
        parent::__construct();
        $this->reportRepository = app(ReportRepository::class);
    }

    public function index()
    {
        $this->title = "Reports Dashboard";
        $this->content = view('admin.reports.index')->render();
        return $this->renderOutput();
    }

    public function financial()
    {
        $this->title = "Financial Reports";
        $this->content = view('admin.reports.financial')->render();
        return $this->renderOutput();
    }

    public function generateFinancialReport(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:revenue,payments,outstanding',
            'period' => 'required|in:today,week,month,quarter,year,custom',
            'start_date' => 'required_if:period,custom|date',
            'end_date' => 'required_if:period,custom|date|after:start_date',
        ]);
        
        $report = $this->reportRepository->generateFinancialReport($validated);
        
        if ($request->has('export')) {
            return Excel::download(
                new FinancialReportExport($report), 
                'financial_report_' . now()->format('Y-m-d') . '.xlsx'
            );
        }
        
        $this->title = "Financial Report Results";
        $this->content = view('admin.reports.financial_results', 
            compact('report', 'validated'))->render();
            
        return $this->renderOutput();
    }

    public function appointments()
    {
        $this->title = "Appointment Reports";
        $this->content = view('admin.reports.appointments')->render();
        return $this->renderOutput();
    }

    public function generateAppointmentReport(Request $request)
    {
        $validated = $request->validate([
            'status' => 'nullable|in:scheduled,completed,cancelled,no_show',
            'dentist_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        
        $report = $this->reportRepository->generateAppointmentReport($validated);
        
        if ($request->has('export')) {
            return Excel::download(
                new AppointmentsExport($report), 
                'appointments_report_' . now()->format('Y-m-d') . '.xlsx'
            );
        }
        
        $this->title = "Appointment Report Results";
        $this->content = view('admin.reports.appointment_results', 
            compact('report', 'validated'))->render();
            
        return $this->renderOutput();
    }

    public function treatments()
    {
        $this->title = "Treatment Reports";
        $this->content = view('admin.reports.treatments')->render();
        return $this->renderOutput();
    }

    public function generateTreatmentReport(Request $request)
    {
        $validated = $request->validate([
            'type' => 'nullable|exists:treatment_types,id',
            'dentist_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        
        $report = $this->reportRepository->generateTreatmentReport($validated);
        
        if ($request->has('export')) {
            return Excel::download(
                new TreatmentsExport($report), 
                'treatments_report_' . now()->format('Y-m-d') . '.xlsx'
            );
        }
        
        $this->title = "Treatment Report Results";
        $this->content = view('admin.reports.treatment_results', 
            compact('report', 'validated'))->render();
            
        return $this->renderOutput();
    }

    public function patients()
    {
        $this->title = "Patient Reports";
        $this->content = view('admin.reports.patients')->render();
        return $this->renderOutput();
    }

    public function generatePatientReport(Request $request)
    {
        $validated = $request->validate([
            'gender' => 'nullable|in:male,female,other',
            'age_from' => 'nullable|integer|min:0',
            'age_to' => 'nullable|integer|min:0|gt:age_from',
            'registration_date_from' => 'nullable|date',
            'registration_date_to' => 'nullable|date|after:registration_date_from',
        ]);
        
        $report = $this->reportRepository->generatePatientReport($validated);
        
        if ($request->has('export')) {
            return Excel::download(
                new PatientsExport($report), 
                'patients_report_' . now()->format('Y-m-d') . '.xlsx'
            );
        }
        
        $this->title = "Patient Report Results";
        $this->content = view('admin.reports.patient_results', 
            compact('report', 'validated'))->render();
            
        return $this->renderOutput();
    }
}