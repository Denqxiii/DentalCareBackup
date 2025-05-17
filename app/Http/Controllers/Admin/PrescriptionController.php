<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PrescriptionRequest;
use App\Models\Patient;
use App\Models\Prescription;
use App\Repositories\PrescriptionRepository;
use PDF;

class PrescriptionController extends BaseController
{
    private $prescriptionRepository;

    public function __construct()
    {
        parent::__construct();
        $this->prescriptionRepository = app(PrescriptionRepository::class);
    }

    public function index()
    {
        $prescriptions = $this->prescriptionRepository->getAllWithPaginate(15);
        
        $this->title = "Prescription Management";
        $this->content = view('admin.prescriptions.index', 
            compact('prescriptions'))->render();
            
        return $this->renderOutput();
    }

    public function create($patientId = null)
    {
        $patients = Patient::active()->get();
        $medicines = Medicine::all();
        
        $this->title = "Create New Prescription";
        $this->content = view('admin.prescriptions.create', 
            compact('patients', 'medicines', 'patientId'))->render();
            
        return $this->renderOutput();
    }

    public function store(PrescriptionRequest $request)
    {
        $data = $request->all();
        $prescription = $this->prescriptionRepository->create($data);
        
        return redirect()
            ->route('admin.prescriptions.show', $prescription->id)
            ->with(['success' => 'Prescription created successfully']);
    }

    public function show($id)
    {
        $prescription = $this->prescriptionRepository->getEdit($id);
        
        $this->title = "Prescription #" . $prescription->id;
        $this->content = view('admin.prescriptions.show', 
            compact('prescription'))->render();
            
        return $this->renderOutput();
    }

    public function edit($id)
    {
        $prescription = $this->prescriptionRepository->getEdit($id);
        $patients = Patient::active()->get();
        $medicines = Medicine::all();
        
        $this->title = "Edit Prescription #" . $prescription->id;
        $this->content = view('admin.prescriptions.edit', 
            compact('prescription', 'patients', 'medicines'))->render();
            
        return $this->renderOutput();
    }

    public function update(PrescriptionRequest $request, $id)
    {
        $prescription = $this->prescriptionRepository->getEdit($id);
        $data = $request->all();
        
        $prescription->update($data);
        
        return redirect()
            ->route('admin.prescriptions.show', $prescription->id)
            ->with(['success' => 'Prescription updated successfully']);
    }

    public function destroy($id)
    {
        $prescription = $this->prescriptionRepository->getEdit($id);
        $prescription->delete();
        
        return redirect()
            ->route('admin.prescriptions.index')
            ->with(['success' => 'Prescription cancelled']);
    }
    
    public function print($id)
    {
        $prescription = $this->prescriptionRepository->getEdit($id);
        $pdf = PDF::loadView('admin.prescriptions.print', compact('prescription'));
        
        return $pdf->stream('prescription_' . $id . '.pdf');
    }
    
    public function patientPrescriptions($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        $prescriptions = $patient->prescriptions()->latest()->paginate(10);
        
        $this->title = "Prescription History: " . $patient->full_name;
        $this->content = view('admin.prescriptions.patient_history', 
            compact('patient', 'prescriptions'))->render();
            
        return $this->renderOutput();
    }
}