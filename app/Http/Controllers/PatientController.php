<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Mail;
use App\Mail\PatientRegistered;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate form data
            $validated = $request->validate([
                'first_name'   => 'required|string|max:255',
                'middle_name'  => 'nullable|string|max:255',
                'last_name'    => 'required|string|max:255',
                'birth_date'   => 'required|date',
                'gender'       => 'required|in:Male,Female',
                'address'      => 'required|string|max:255',
                'email'        => 'required|email|unique:patients,email',
                'phone' => 'required|string|max:15',
            ]);

            // Generate a unique 5-character patient ID
            do {
                $patient_id = strtoupper(Str::random(5));
            } while (Patient::where('patient_id', $patient_id)->exists());

            // Store patient data
            $patient = Patient::create([
                'patient_id'   => $patient_id,
                'first_name'   => $validated['first_name'],
                'middle_name'  => $validated['middle_name'] ?? null,
                'last_name'    => $validated['last_name'],
                'birth_date'   => $validated['birth_date'],
                'gender'       => $validated['gender'],
                'address'      => $validated['address'],
                'email'        => $validated['email'],
                'phone' => $validated['phone'],
            ]);

            // Log the created patient for debugging
            Log::info('New patient registered:', ['patient' => $patient]);

            // Send email notification (disable in local testing if needed)
            Mail::to($patient->email)->send(new PatientRegistered($patient));

            // Return a JSON response for AJAX requests
            return response()->json([
                'status'  => 'success',
                'message' => 'Patient registered successfully!',
                'data'    => $patient
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors
            Log::error('Validation failed:', ['errors' => $e->errors()]);

            return response()->json([
                'status' => 'error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            // Log unexpected errors
            Log::error('Registration error:', ['message' => $e->getMessage()]);

            return response()->json([
                'status'  => 'error',
                'message' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }

    public function index()
    {
        $patients = Patient::all();
        return view('patients.registered_patients', compact('patients'));
    }

    public function edit($patient_id)
    {
        $patient = Patient::findOrFail($patient_id);
        return view('patients.edit_patient', compact('patient'));
    }

    public function update(Request $request, $patient_id)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'birth_date' => 'required|date',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email,' . $patient_id,
            'phone_number' => 'required|string|max:15',
        ]);

        $patient = Patient::findOrFail($patient_id);
        $patient->update($validated);

        return redirect()->route('patients.show', $patient_id)->with('status', 'Patient updated successfully!');
    }

    public function show($patient_id)
    {
        $patient = Patient::with(['medicalHistories', 'treatmentRecords', 'appointments'])->findOrFail($patient_id);
        return view('patients.show_details', compact('patient'));
    }


    public function destroy($patient_id)
    {
        try {
            // Find the patient by ID
            $patient = Patient::where('patient_id', $patient_id)->firstOrFail();

            // Delete the patient
            $patient->delete();

            // Log the deletion
            Log::info('Patient deleted:', ['patient_id' => $patient_id]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Patient deleted successfully!'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Deletion error:', ['message' => $e->getMessage()]);

            return response()->json([
                'status'  => 'error',
                'message' => 'An error occurred while deleting the patient.'
            ], 500);
        }
    }

    public function fetchPatientDetails($id)
    {
        $patient = Patient::find($id);

        if ($patient) {
            return response()->json(['success' => true, 'patient' => $patient]);
        }

        return response()->json(['success' => false], 404);
    }

    public function history()
    {
        // Fetch patient history data (replace with your actual logic)
        $patients = Patient::with('appointments')->get();

        // Return the patient history view
        return view('patients.history', compact('patients'));
    }
}