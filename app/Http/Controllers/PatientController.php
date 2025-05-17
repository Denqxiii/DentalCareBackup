<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\PatientRegistered;

class PatientController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email',
            'phone' => 'required|string|max:20',
            'gender' => 'required|in:Male,Female,Other',
            'birth_date' => 'required|date',
            'address' => 'required|string',
            // middle_name is optional
        ]);

        // Add patient_id generation
        $validated['patient_id'] = 'DC' . strtoupper(Str::random(5)); // DC followed by 5 random chars
        
        $patient = Patient::create($validated);
        
        // Send registration email
        Mail::to($patient->email)->send(new PatientRegistered($patient));

        return response()->json([
            'success' => true,
            'patient_id' => $patient->patient_id,
            'message' => 'Registration successful! Check your email for details.'
        ]);
    }

    public function getByPatientId($patientId)
    {
        $patient = Patient::where('patient_id', $patientId)->first();

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