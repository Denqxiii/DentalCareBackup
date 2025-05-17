<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\TreatmentRequest;
use App\Models\Patient;
use App\Models\Treatment;
use App\Models\TreatmentType;
use App\Repositories\TreatmentRepository;

class TreatmentController extends BaseController
{
    private $treatmentRepository;

    public function __construct()
    {
        parent::__construct();
        $this->treatmentRepository = app(TreatmentRepository::class);
    }

    public function index()
    {
        $treatments = $this->treatmentRepository->getAllWithPaginate(15);
        
        $this->title = "Treatment Records";
        $this->content = view('admin.treatments.index', 
            compact('treatments'))->render();
            
        return $this->renderOutput();
    }

    public function create($patientId = null)
    {
        $patients = Patient::active()->get();
        $dentists = User::dentists()->get();
        $types = TreatmentType::all();
        
        $this->title = "Add New Treatment";
        $this->content = view('admin.treatments.create', 
            compact('patients', 'dentists', 'types', 'patientId'))->render();
            
        return $this->renderOutput();
    }

    public function store(TreatmentRequest $request)
    {
        $data = $request->all();
        $treatment = $this->treatmentRepository->create($data);
        
        // Create invoice item if treatment has cost
        if ($treatment->cost > 0) {
            $this->createInvoiceItem($treatment);
        }
        
        return redirect()
            ->route('admin.treatments.show', $treatment->id)
            ->with(['success' => 'Treatment record created successfully']);
    }

    public function show($id)
    {
        $treatment = $this->treatmentRepository->getEdit($id);
        
        $this->title = "Treatment Details";
        $this->content = view('admin.treatments.show', 
            compact('treatment'))->render();
            
        return $this->renderOutput();
    }

    public function edit($id)
    {
        $treatment = $this->treatmentRepository->getEdit($id);
        $patients = Patient::active()->get();
        $dentists = User::dentists()->get();
        $types = TreatmentType::all();
        
        $this->title = "Edit Treatment";
        $this->content = view('admin.treatments.edit', 
            compact('treatment', 'patients', 'dentists', 'types'))->render();
            
        return $this->renderOutput();
    }

    public function update(TreatmentRequest $request, $id)
    {
        $treatment = $this->treatmentRepository->getEdit($id);
        $data = $request->all();
        
        $treatment->update($data);
        
        // Update related invoice item if cost changed
        if ($treatment->wasChanged('cost') && $treatment->cost > 0) {
            $this->updateInvoiceItem($treatment);
        }
        
        return redirect()
            ->route('admin.treatments.show', $treatment->id)
            ->with(['success' => 'Treatment record updated successfully']);
    }

    public function destroy($id)
    {
        $treatment = $this->treatmentRepository->getEdit($id);
        $treatment->delete();
        
        return redirect()
            ->route('admin.treatments.index')
            ->with(['success' => 'Treatment record archived']);
    }
    
    public function patientTreatments($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        $treatments = $patient->treatments()->latest()->paginate(10);
        
        $this->title = "Treatment History: " . $patient->full_name;
        $this->content = view('admin.treatments.patient_history', 
            compact('patient', 'treatments'))->render();
            
        return $this->renderOutput();
    }
    
    private function createInvoiceItem(Treatment $treatment)
    {
        // Logic to create invoice item
    }
    
    private function updateInvoiceItem(Treatment $treatment)
    {
        // Logic to update invoice item
    }
}