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
            'birth_date' => 'required|date|before:today',
            'address' => 'required|string|max:500',
            'middle_name' => 'nullable|string|max:255',
        ]);

        // Generate unique patient ID
        do {
            $validated['patient_id'] = 'PAT-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        } while (Patient::where('patient_id', $validated['patient_id'])->exists());

        try {
            $patient = Patient::create($validated);
            
            Mail::to($patient->email)->queue(new PatientRegistered($patient));

            return response()->json([
                'success' => true,
                'patient_id' => $patient->patient_id,
                'message' => 'Registration successful!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
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

    public function index()
    {
        $patients = Patient::all();
        return view('admin.patients.index', compact('patients'));
    }
}