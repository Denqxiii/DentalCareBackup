<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PatientRequest;
use App\Models\Patient;
use App\Repositories\PatientRepository;
use Illuminate\Http\Request;

class PatientController extends BaseController
{
    private $patientRepository;

    public function __construct()
    {
        parent::__construct();
        $this->patientRepository = app(PatientRepository::class);
    }

    public function index()
    {
        $this->title = "Patient Management";
        $patients = $this->patientRepository->getAllWithPaginate(15);
        
        $this->content = view('admin.patients.index', 
            compact('patients'))->render();
            
        return $this->renderOutput();
    }

    public function create()
    {
        $this->title = "Add New Patient";
        $this->content = view('admin.patients.create')->render();
        return $this->renderOutput();
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

    public function show($id)
    {
        $patient = $this->patientRepository->getEdit($id);
        $appointments = $patient->appointments()->latest()->paginate(5);
        $treatments = $patient->treatments()->latest()->paginate(5);
        
        $this->title = "Patient: " . $patient->full_name;
        $this->content = view('admin.patients.show', 
            compact('patient', 'appointments', 'treatments'))->render();
            
        return $this->renderOutput();
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
}