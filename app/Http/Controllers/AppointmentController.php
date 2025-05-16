<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Treatment; 
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'patient_id' => 'required|exists:patients,patient_id',
                'treatment_id' => 'required|exists:treatments,id',
                'appointment_date' => 'required|date|after_or_equal:today',
                'appointment_time' => 'required|date_format:H:i',
                'phone_number' => 'required|string|max:20',
                'gender' => 'required|in:Male,Female,Other',
                'message' => 'nullable|string|max:500'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => 'Validation failed'
                ], 422);
            }

            $patient = Patient::where('patient_id', $request->patient_id)->first();
            if (!$patient) {
                return response()->json([
                    'success' => false,
                    'message' => 'Patient not found'
                ], 404);
            }

            // Check for existing appointment
            $existing = Appointment::where('appointment_date', $request->appointment_date)
                ->where('appointment_time', $request->appointment_time)
                ->exists();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'This time slot is already booked'
                ], 409);
            }

            // Create appointment
            $appointment = Appointment::create([
                'patient_id' => $patient->patient_id,
                'treatment_id' => $request->treatment_id,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'notes' => $request->message, // Using 'notes' instead of 'message'
                'status' => 'Pending'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Appointment booked successfully',
                'data' => $appointment
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Appointment booking failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to book appointment',
                'error' => env('APP_DEBUG') ? $e->getMessage() : null
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
        $appointments = Appointment::where('patient_id', $patient_id)
            ->with(['treatmentRecords' => function($query) {
                $query->select('id', 'appointment_id', 'treatment_type', 'price');
            }])
            ->select('id', 'patient_id', 'appointment_date', 'status', 'treatment_type')
            ->orderBy('appointment_date', 'desc')
            ->get()
            ->map(function($appointment) {
                // Get treatment price from related treatment records if available
                $treatmentPrice = $appointment->treatmentRecords->sum('price');
                
                return [
                    'id' => $appointment->id,
                    'patient_id' => $appointment->patient_id,
                    'appointment_date' => $appointment->appointment_date,
                    'status' => $appointment->status,
                    'treatment_type' => $appointment->treatment_type,
                    'treatment_price' => $treatmentPrice
                ];
            });
        
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