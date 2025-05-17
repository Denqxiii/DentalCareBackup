<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Treatment;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class AppointmentController extends Controller
{
    public function createPublic()
    {
        $treatments = Treatment::active()->get();
        return view('book_appointment', compact('treatments'));
    }

    public function storeGuest(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,patient_id',
            'patient_name' => 'required|string|max:255',
            'patient_phone' => 'required|string|max:20',
            'treatment_id' => 'required|exists:treatments,id',
            'appointment_date' => 'required|date|after:now',
            'message' => 'nullable|string',
            'gender' => 'required|in:Male,Female,Other'
        ]);

        $appointment = Appointment::create($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Appointment booked successfully!',
            'data' => $appointment
        ]);
    }


    protected function createNewPatient(array $data)
    {
        $nameParts = explode(' ', $data['full_name'], 2);
        
        return Patient::create([
            'first_name' => $nameParts[0],
            'last_name' => $nameParts[1] ?? '',
            'email' => $data['email'],
            'phone' => $data['phone_number'],
            'gender' => $data['gender'] ?? 'Unknown',
            'birth_date' => now()->subYears(30)->format('Y-m-d'), // Default
            'address' => 'Not provided'
        ]);
    }

    public function getPatientDetails($patientId)
    {
        $patient = Patient::where('patient_id', $patientId)->first(); // Changed to use patient_id column
        
        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'patient' => [
                'full_name' => $patient->first_name . ' ' . $patient->last_name,
                'phone' => $patient->phone,
                'gender' => $patient->gender,
                'email' => $patient->email
            ]
        ]);
    }

    public function index()
    {
        $query = Appointment::with(['patient', 'treatment'])
            ->latest();
        
        // Improved search filter
        if ($search = request('search')) {
            $query->whereHas('patient', function($q) use ($search) {
                $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                ->orWhere('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('middle_name', 'like', "%{$search}%");
            });
        }
        
        // Treatment filter
        if ($treatmentId = request('treatment')) {
            $query->where('treatment_id', $treatmentId);
        }
        
        $appointments = $query->paginate(10);
        $treatments = Treatment::all();
        
        return view('admin.appointments.index', compact('appointments', 'treatments'));
    }

    public function create()
    {
        $patients = Patient::orderBy('last_name')->orderBy('first_name')->get();
        $treatments = Treatment::active()->get();
        
        return view('admin.appointments.create', compact('patients', 'treatments'));
    }

    public function complete()
    {
        $appointments = Appointment::with(['patient', 'treatment'])
                                ->where('status', 'completed')
                                ->orderBy('appointment_date', 'desc')
                                ->paginate(10);
                                
        return view('admin.appointments.completed', compact('appointments'));
    }

    public function markComplete(Appointment $appointment)
    {
        $appointment->update(['status' => 'completed']);
        
        return back()->with('success', 'Appointment marked as completed.');
    }

    public function markCancel(Appointment $appointment)
    {
        $appointment->update(['status' => 'canceled']);
        
        return back()->with('success', 'Appointment has been canceled.');
    }
}