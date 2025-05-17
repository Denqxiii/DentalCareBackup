@extends('layouts.admin')

@section('title', 'Create Prescription')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Create New Prescription</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.prescriptions.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="patient_id" class="form-label">Patient</label>
                    <select name="patient_id" id="patient_id" class="form-select" required>
                        <option value="">Select Patient</option>
                        @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="doctor_id" class="form-label">Doctor</label>
                    <select name="doctor_id" id="doctor_id" class="form-select" required>
                        <option value="">Select Doctor</option>
                        @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="medication" class="form-label">Medication</label>
                <textarea name="medication" id="medication" rows="3" class="form-control" required></textarea>
            </div>
            
            <div class="mb-3">
                <label for="dosage" class="form-label">Dosage Instructions</label>
                <textarea name="dosage" id="dosage" rows="3" class="form-control" required></textarea>
            </div>
            
            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea name="notes" id="notes" rows="2" class="form-control"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Save Prescription</button>
            <a href="{{ route('admin.prescriptions.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection