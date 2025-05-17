<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function create()
    {
        $patients = Patient::orderBy('first_name')->get();
        $doctors = User::where('role', 'doctor')->orderBy('name')->get();
        
        return view('admin.prescription.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'medication' => 'required|string|max:500',
            'dosage' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        $prescription = Prescription::create([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $validated['doctor_id'],
            'medication' => $validated['medication'],
            'dosage' => $validated['dosage'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'active',
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.prescriptions.show', $prescription->id)
            ->with('success', 'Prescription created successfully!');
    }

    public function index()
    {
        $prescriptions = Prescription::with(['patient', 'doctor'])
            ->latest()
            ->paginate(10);

        return view('admin.prescription.index', compact('prescriptions'));
    }
}