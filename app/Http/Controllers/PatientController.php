<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Mail;
use App\Mail\PatientRegistered;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:patients,email',
                'phone' => 'required|string|max:20',
                'gender' => 'required|in:Male,Female,Other',
                'birth_date' => 'required|date',
                'address' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Generate patient ID (example implementation)
            $patientId = strtoupper(substr($request->first_name, 0, 1) . 
                                substr($request->last_name, 0, 1) . 
                                Str::random(3));

            $patient = Patient::create([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name ?? null,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'patient_id' => $patientId,
            ]);

            // Send registration email (if needed)
            Mail::to($patient->email)->send(new PatientRegistered($patient));

            return response()->json([
                'status' => 'success',
                'message' => 'Patient registered successfully!',
                'data' => $patient
            ]);

        } catch (\Exception $e) {
            Log::error('Patient registration error: '.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Registration failed. Please try again.',
                'error' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    
    public function index()
    {
        $patients = Patient::paginate(10);
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

    public function showDetails($patientId)
    {
        $patient = Patient::with(['medicalHistories', 'treatmentRecords', 'appointments'])
                        ->findOrFail($patientId);

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
        
        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'patient' => [
                'first_name' => $patient->first_name,
                'middle_name' => $patient->middle_name,
                'last_name' => $patient->last_name,
                'phone' => $patient->phone,
                'gender' => $patient->gender
                // Add other fields you need
            ]
        ]);
    }

    public function history()
    {
        // Fetch patient history data (replace with your actual logic)
        $patients = Patient::with('appointments')->get();

        // Return the patient history view
        return view('patients.history', compact('patients'));
    }
}