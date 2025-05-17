@extends('admin.layouts.app')

@section('title', 'Create Prescription')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>New Prescription</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.prescriptions.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Patient</label>
                        <select name="patient_id" class="form-control" required>
                            @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Dentist</label>
                        <select name="dentist_id" class="form-control" required>
                            @foreach($dentists as $dentist)
                            <option value="{{ $dentist->id }}">Dr. {{ $dentist->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div id="medication-container">
                <div class="medication-item row mb-3">
                    <div class="col-md-5">
                        <input type="text" name="medications[0][name]" 
                               class="form-control" placeholder="Medication" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="medications[0][dosage]" 
                               class="form-control" placeholder="Dosage" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="medications[0][frequency]" 
                               class="form-control" placeholder="Frequency" required>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger remove-medication">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

            <button type="button" id="add-medication" class="btn btn-secondary mb-3">
                <i class="fas fa-plus"></i> Add Medication
            </button>

            <div class="form-group">
                <label>Instructions</label>
                <textarea name="instructions" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save Prescription</button>
        </form>
    </div>
</div>

<script>
    let medCounter = 1;
    $('#add-medication').click(function() {
        const newItem = `
        <div class="medication-item row mb-3">
            <div class="col-md-5">
                <input type="text" name="medications[${medCounter}][name]" 
                       class="form-control" placeholder="Medication" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="medications[${medCounter}][dosage]" 
                       class="form-control" placeholder="Dosage" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="medications[${medCounter}][frequency]" 
                       class="form-control" placeholder="Frequency" required>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger remove-medication">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        `;
        $('#medication-container').append(newItem);
        medCounter++;
    });

    $(document).on('click', '.remove-medication', function() {
        $(this).closest('.medication-item').remove();
    });
</script>
@endsection