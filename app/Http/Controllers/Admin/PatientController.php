<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PatientRequest;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Treatment;
use App\Repositories\PatientRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  

class PatientController extends Controller
{
    private $patientRepository;

    public function __construct(PatientRepository $patientRepository)
    {
        $this->middleware('auth');
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
        
        $this->patientRepository = $patientRepository;
    }

    public function index()
    {
        $appointmentCounts = Appointment::select('patient_id', DB::raw('count(*) as total'))
            ->groupBy('patient_id')
            ->pluck('total', 'patient_id');  // returns [patient_id => count] associative array

        $patients = $this->patientRepository->getAllWithPaginate(15);
        
        return view('admin.patients.index', compact('patients', 'appointmentCounts')); // <-- add appointmentCounts here
    }


    public function create()
    {
        $patients = $this->patientRepository->getAllWithPaginate(15);
        return view('admin.patients.create', compact('patients'));
    }

    public function store(PatientRequest $request)
    {
        $data = $request->all();
        $patient = $this->patientRepository->create($data);
        
        // Generate patient ID
        $patient->patient_id = 'DENT-' . str_pad($patient->id, 6, '0', STR_PAD_LEFT);
        $patient->save();
        
        return redirect()
            ->route('admin.patients.show', $patient->id)
            ->with(['success' => 'Patient created successfully']);
    }

    public function show(Patient $patient)  // Implicit model binding will now work
    {
        $appointments = $patient->appointments()->latest()->paginate(5);
        $treatments = $patient->treatments()->latest()->paginate(5);
        
        return view('admin.patients.show', compact('patient', 'appointments', 'treatments'));
    }

    public function edit($id)
    {
        $patient = $this->patientRepository->getEdit($id);
        
        $this->title = "Edit Patient: " . $patient->full_name;
        $this->content = view('admin.patients.edit', 
            compact('patient'))->render();
            
        return $this->renderOutput();
    }

    public function update(PatientRequest $request, $id)
    {
        $patient = $this->patientRepository->getEdit($id);
        $data = $request->all();
        
        $result = $patient->update($data);
        
        return redirect()
            ->route('admin.patients.show', $patient->id)
            ->with(['success' => 'Patient updated successfully']);
    }

    public function destroy($id)
    {
        $patient = $this->patientRepository->getEdit($id);
        $patient->delete();
        
        return redirect()
            ->route('admin.patients.index')
            ->with(['success' => 'Patient record moved to archive']);
    }
    
    public function search(Request $request)
    {
        $query = $request->input('query');
        $patients = $this->patientRepository->search($query);
        
        return view('admin.patients._search_results', compact('patients'));
    }

    protected function renderOutput()
    {
        return view('layouts.admin', [
            'title' => $this->title ?? 'Admin Panel',
            'content' => $this->content ?? '',
        ]);
    }

    public function getEdit($patientId)
    {
        return Patient::where('patient_id', $patientId)->firstOrFail();
    }

    public function records($patientId)
    {
        $patient = Patient::where('patient_id', $patientId)->firstOrFail();
        // Fetch related medical records or appointments as needed
        $appointments = $patient->appointments()->paginate(10);
        
        return view('admin.patients.records', compact('patient', 'appointments'));
    }
}