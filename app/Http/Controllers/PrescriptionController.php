<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of prescriptions
     */
    public function index()
    {
        $prescriptions = Prescription::with(['patient', 'doctor'])
            ->latest()
            ->paginate(10);

        return view('prescriptions.index', compact('prescriptions'));
    }

    /**
     * Show the form for creating a new prescription
     */
    public function create()
    {
        $patients = Patient::all();
        $doctors = User::where('role', 'doctor')->get(); // Adjust based on your user roles
        
        return view('prescriptions.create', compact('patients', 'doctors'));
    }

    /**
     * Store a newly created prescription
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'diagnosis' => 'required|string',
            'instructions' => 'nullable|string',
            'medications' => 'required|array',
            'medications.*.name' => 'required|string',
            'medications.*.dosage' => 'required|string',
            'medications.*.frequency' => 'required|string',
            'medications.*.duration' => 'required|string'
        ]);

        // Create prescription
        $prescription = Prescription::create([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $validated['doctor_id'],
            'diagnosis' => $validated['diagnosis'],
            'instructions' => $validated['instructions']
        ]);

        // Add medications
        foreach ($validated['medications'] as $medication) {
            $prescription->medications()->create($medication);
        }

        return redirect()->route('prescriptions.show', $prescription)
            ->with('success', 'Prescription created successfully!');
    }

    /**
     * Display the specified prescription
     */
    public function show(Prescription $prescription)
    {
        $prescription->load(['patient', 'doctor', 'medications']);
        return view('prescriptions.show', compact('prescription'));
    }

    /**
     * Show the form for editing the prescription
     */
    public function edit(Prescription $prescription)
    {
        $patients = Patient::all();
        $doctors = User::where('role', 'doctor')->get();
        $prescription->load('medications');
        
        return view('prescriptions.edit', compact('prescription', 'patients', 'doctors'));
    }

    /**
     * Update the specified prescription
     */
    public function update(Request $request, Prescription $prescription)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'diagnosis' => 'required|string',
            'instructions' => 'nullable|string',
            'medications' => 'required|array',
            'medications.*.id' => 'sometimes|exists:prescription_medications,id',
            'medications.*.name' => 'required|string',
            'medications.*.dosage' => 'required|string',
            'medications.*.frequency' => 'required|string',
            'medications.*.duration' => 'required|string'
        ]);

        // Update prescription
        $prescription->update([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $validated['doctor_id'],
            'diagnosis' => $validated['diagnosis'],
            'instructions' => $validated['instructions']
        ]);

        // Sync medications
        $medications = collect($validated['medications'])->mapWithKeys(function ($item) {
            return [$item['id'] ?? null => $item];
        });

        $prescription->medications()->upsert(
            $medications->toArray(),
            ['id'],
            ['name', 'dosage', 'frequency', 'duration']
        );

        return redirect()->route('prescriptions.show', $prescription)
            ->with('success', 'Prescription updated successfully!');
    }

    /**
     * Remove the specified prescription
     */
    public function destroy(Prescription $prescription)
    {
        $prescription->delete();
        return redirect()->route('prescriptions.index')
            ->with('success', 'Prescription deleted successfully!');
    }
}