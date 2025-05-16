<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Treatment;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with('patient')
            ->latest()
            ->when(request('search'), function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->whereHas('patient', function($q) use ($search) {
                        $q->where('first_name', 'like', '%'.$search.'%')
                        ->orWhere('last_name', 'like', '%'.$search.'%');
                    })
                    ->orWhere('treatment_type', 'like', '%'.$search.'%');
                });
            })
            ->when(request('status'), function($query, $status) {
                $query->where('status', $status);
            })
            ->when(request('date'), function($query, $date) {
                $query->whereDate('appointment_date', $date);
            })
            ->paginate(10);

        // Add these stats calculations
        $stats = [
            'total' => Appointment::count(),
            'upcoming' => Appointment::where('appointment_date', '>=', now()->format('Y-m-d'))
                                ->where('status', '!=', 'Cancelled')
                                ->where('status', '!=', 'Completed')
                                ->count(),
            'completed' => Appointment::where('status', 'Completed')->count(),
            'cancelled' => Appointment::where('status', 'Cancelled')->count()
        ];

        return view('admin.appointments.index', compact('appointments', 'stats'));
    }

    public function create()
    {
        $treatments = \App\Models\Treatment::all();
        return view('book_appointment', compact('treatments'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'patient_id' => 'required|exists:patients,patient_id',
                'treatment_id' => 'required|exists:treatments,id',
                'appointment_date' => 'required|date',
                'appointment_time' => 'required|string',
                'message' => 'nullable|string',
                'gender' => 'required|string|in:Male,Female,Other',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $patientId = trim($request->patient_id);
            Log::info('Booking appointment for patient_id: ' . $patientId);
            $patient = Patient::where('patient_id', $patientId)->first();
            Log::info('Patient lookup result:', ['patient' => $patient]);

            if (!$patient) {
                return response()->json([
                    'success' => false,
                    'message' => 'Patient not found'
                ], 404);
            }

            // Check if the appointment time is available
            $existingAppointment = Appointment::where('appointment_date', $request->appointment_date)
                ->where('appointment_time', $request->appointment_time)
                ->first();

            if ($existingAppointment) {
                return response()->json([
                    'success' => false,
                    'message' => 'This time slot is already booked. Please select another time.'
                ], 422);
            }

            $appointment = Appointment::create([
                'patient_id' => $patient->patient_id, // Use the string ID
                'treatment_id' => $request->treatment_id,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'message' => $request->message,
                'status' => 'pending'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Appointment booked successfully',
                'data' => $appointment
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating appointment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to book appointment. ' . $e->getMessage()
            ], 500);
        }
    }

    public function manage($id)
    {
        $appointment = Appointment::with('patient')->findOrFail($id);

        return view('admin.appointments.manage', compact('appointment'));
    }

    public function getPatientDetails($id)
    {
        try {
            Log::info('Fetching patient details for ID: ' . $id);
            
            // Try to find patient by ID
            $patient = Patient::find($id);
            
            if (!$patient) {
                Log::warning('Patient not found with ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Patient not found'
                ], 404);
            }

            Log::info('Patient found:', ['patient' => $patient->toArray()]);
            
            return response()->json([
                'success' => true,
                'patient' => $patient
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching patient details: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching patient details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAppointments($patient_id)
    {
        $appointments = Appointment::where('patient_id', $patient_id)->get();

        return response()->json($appointments);
    }

    // app/Http/Controllers/AppointmentController.php
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,Completed,Cancelled'
        ]);

        $appointment->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Status updated successfully');
    }

    public function show(Appointment $appointment)
    {
        return view('admin.appointments.show', [
            'appointment' => $appointment->load(['patient', 'treatment'])
        ]);
    }
}