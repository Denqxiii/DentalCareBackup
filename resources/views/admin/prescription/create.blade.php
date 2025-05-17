@extends('layouts.admin')

@section('title', 'Create Prescription')

@section('content')
<div class="card shadow-sm border-0 rounded-lg">
    <div class="card-header bg-gradient-primary text-white py-3">
        <div class="d-flex align-items-center">
            <i class="fas fa-prescription-bottle-alt me-2"></i>
            <h5 class="mb-0">Create New Prescription</h5>
        </div>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.prescriptions.store') }}" method="POST">
            @csrf
            
            <div class="row g-3">
                <div class="col-md-6 mb-3">
                    <label for="patient_id" class="form-label fw-bold">
                        <i class="fas fa-user me-1 text-primary"></i> Patient
                    </label>
                    <select name="patient_id" id="patient_id" class="form-select form-select-lg shadow-sm" required>
                        <option value="">-- Select Patient --</option>
                        @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
                        @endforeach
                    </select>
                    <div class="form-text">Select the patient receiving this prescription</div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="doctor_id" class="form-label fw-bold">
                        <i class="fas fa-user-md me-1 text-primary"></i> Doctor
                    </label>
                    <select name="doctor_id" id="doctor_id" class="form-select form-select-lg shadow-sm" required>
                        <option value="">-- Select Doctor --</option>
                        @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                    <div class="form-text">Select the doctor prescribing the medication</div>
                </div>
            </div>

            <hr class="my-4">
            
            <div class="mb-4">
                <label for="medication" class="form-label fw-bold">
                    <i class="fas fa-pills me-1 text-primary"></i> Medication
                </label>
                <textarea name="medication" id="medication" rows="3" class="form-control shadow-sm" 
                    placeholder="Enter medication name, strength, and form" required></textarea>
                <div class="form-text">Specify the medication name, strength, and form</div>
            </div>
            
            <div class="mb-4">
                <label for="dosage" class="form-label fw-bold">
                    <i class="fas fa-prescription me-1 text-primary"></i> Dosage Instructions
                </label>
                <textarea name="dosage" id="dosage" rows="3" class="form-control shadow-sm" 
                    placeholder="Enter detailed dosage instructions" required></textarea>
                <div class="form-text">Include frequency, timing, and special instructions</div>
            </div>
            
            <div class="mb-4">
                <label for="notes" class="form-label fw-bold">
                    <i class="fas fa-sticky-note me-1 text-primary"></i> Additional Notes
                </label>
                <textarea name="notes" id="notes" rows="2" class="form-control shadow-sm" 
                    placeholder="Enter any additional notes or instructions (optional)"></textarea>
                <div class="form-text">Optional: Add any additional information for the patient or pharmacist</div>
            </div>
            
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.prescriptions.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                    <i class="fas fa-times me-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary btn-lg px-4">
                    <i class="fas fa-save me-1"></i> Save Prescription
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Add select2 for better dropdown experience (requires select2 plugin)
        if($.fn.select2) {
            $('#patient_id, #doctor_id').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select an option',
                width: '100%'
            });
        }
    });
</script>
@endsection