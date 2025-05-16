@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">{{ isset($prescription) ? 'Edit' : 'Create' }} Prescription</h1>

    <form action="{{ isset($prescription) ? route('prescriptions.update', $prescription) : route('prescriptions.store') }}" method="POST">
        @csrf
        @if(isset($prescription))
            @method('PUT')
        @endif

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Patient Selection -->
                <div>
                    <label for="patient_id" class="block text-sm font-medium text-gray-700">Patient</label>
                    <select id="patient_id" name="patient_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Select Patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ (isset($prescription) && $prescription->patient_id == $patient->id) ? 'selected' : '' }}>
                                {{ $patient->first_name }} {{ $patient->last_name }} ({{ $patient->patient_id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Doctor Selection -->
                <div>
                    <label for="doctor_id" class="block text-sm font-medium text-gray-700">Doctor</label>
                    <select id="doctor_id" name="doctor_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Select Doctor</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ (isset($prescription) && $prescription->doctor_id == $doctor->id) ? 'selected' : '' }}>
                                Dr. {{ $doctor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Diagnosis -->
            <div class="mt-6">
                <label for="diagnosis" class="block text-sm font-medium text-gray-700">Diagnosis</label>
                <textarea id="diagnosis" name="diagnosis" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $prescription->diagnosis ?? old('diagnosis') }}</textarea>
            </div>

            <!-- Instructions -->
            <div class="mt-6">
                <label for="instructions" class="block text-sm font-medium text-gray-700">Instructions</label>
                <textarea id="instructions" name="instructions" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $prescription->instructions ?? old('instructions') }}</textarea>
            </div>
        </div>

        <!-- Medications -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-medium mb-4">Medications</h2>
            
            <div id="medications-container">
                @if(isset($prescription) && $prescription->medications->count())
                    @foreach($prescription->medications as $index => $medication)
                        <div class="medication-item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                            <input type="hidden" name="medications[{{ $index }}][id]" value="{{ $medication->id }}">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="medications[{{ $index }}][name]" value="{{ $medication->name }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Dosage</label>
                                <input type="text" name="medications[{{ $index }}][dosage]" value="{{ $medication->dosage }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Frequency</label>
                                <input type="text" name="medications[{{ $index }}][frequency]" value="{{ $medication->frequency }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Duration</label>
                                <input type="text" name="medications[{{ $index }}][duration]" value="{{ $medication->duration }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="medication-item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="medications[0][name]" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Dosage</label>
                            <input type="text" name="medications[0][dosage]" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Frequency</label>
                            <input type="text" name="medications[0][frequency]" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Duration</label>
                            <input type="text" name="medications[0][duration]" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>
                @endif
            </div>

            <button type="button" id="add-medication" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded">
                Add Another Medication
            </button>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                {{ isset($prescription) ? 'Update' : 'Create' }} Prescription
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('add-medication').addEventListener('click', function() {
        const container = document.getElementById('medications-container');
        const index = document.querySelectorAll('.medication-item').length;
        
        const newMedication = document.createElement('div');
        newMedication.className = 'medication-item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4';
        newMedication.innerHTML = `
            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="medications[${index}][name]" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Dosage</label>
                <input type="text" name="medications[${index}][dosage]" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Frequency</label>
                <input type="text" name="medications[${index}][frequency]" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Duration</label>
                <input type="text" name="medications[${index}][duration]" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
        `;
        
        container.appendChild(newMedication);
    });
</script>
@endsection