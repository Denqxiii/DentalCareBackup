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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,patient_id',
            'patient_name' => 'required|string|max:255',
            'patient_phone' => 'required|string|max:20',
            'treatment_id' => 'required|exists:treatments,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'gender' => 'required|in:Male,Female,Other',
            'message' => 'nullable|string'
        ]);

        // Get the first available user or create a default one
        $defaultUser = User::first();
        
        if (!$defaultUser) {
            $defaultUser = User::create([
                'name' => 'System Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
            ]);
        }

        $appointment = Appointment::create([
            'patient_id' => Patient::where('patient_id', $validated['patient_id'])->first()->id,
            'treatment_id' => $validated['treatment_id'],
            'user_id' => auth()->id() ?? $defaultUser->id, // Use logged-in user or default
            'appointment_date' => $validated['appointment_date'] . ' ' . $validated['appointment_time'],
            'status' => 'scheduled',
            'notes' => $validated['message'] ?? null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment booked successfully'
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
}