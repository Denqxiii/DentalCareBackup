@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Prescription #{{ $prescription->id }}</h1>
        <div>
            <a href="{{ route('prescriptions.edit', $prescription) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded mr-2">
                Edit
            </a>
            <form action="{{ route('prescriptions.destroy', $prescription) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded" onclick="return confirm('Are you sure?')">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 px-6 py-4 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold">Medical Prescription</h2>
                    <p class="text-sm">Date: {{ $prescription->created_at->format('M d, Y') }}</p>
                </div>
                <div class="text-right">
                    <p class="font-semibold">Dr. {{ $prescription->doctor->name }}</p>
                    <p class="text-sm">{{ $prescription->doctor->specialization ?? 'General Practitioner' }}</p>
                </div>
            </div>
        </div>

        <!-- Patient Info -->
        <div class="px-6 py-4 border-b">
            <div class="flex justify-between">
                <div>
                    <h3 class="font-semibold">Patient Information</h3>
                    <p>{{ $prescription->patient->first_name }} {{ $prescription->patient->last_name }}</p>
                    <p>DOB: {{ $prescription->patient->birth_date->format('M d, Y') }}</p>
                    <p>Gender: {{ $prescription->patient->gender }}</p>
                </div>
                <div class="text-right">
                    <p>Patient ID: {{ $prescription->patient->patient_id }}</p>
                    <p>Phone: {{ $prescription->patient->phone }}</p>
                </div>
            </div>
        </div>

        <!-- Prescription Content -->
        <div class="px-6 py-4">
            <div class="mb-6">
                <h3 class="font-semibold text-lg mb-2">Diagnosis</h3>
                <p class="bg-gray-100 p-3 rounded">{{ $prescription->diagnosis }}</p>
            </div>

            <div class="mb-6">
                <h3 class="font-semibold text-lg mb-2">Medications</h3>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 text-left border">Medication</th>
                            <th class="p-2 text-left border">Dosage</th>
                            <th class="p-2 text-left border">Frequency</th>
                            <th class="p-2 text-left border">Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prescription->medications as $medication)
                        <tr class="border-b">
                            <td class="p-2 border">{{ $medication->name }}</td>
                            <td class="p-2 border">{{ $medication->dosage }}</td>
                            <td class="p-2 border">{{ $medication->frequency }}</td>
                            <td class="p-2 border">{{ $medication->duration }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($prescription->instructions)
            <div class="mb-6">
                <h3 class="font-semibold text-lg mb-2">Instructions</h3>
                <p class="bg-gray-100 p-3 rounded whitespace-pre-line">{{ $prescription->instructions }}</p>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 bg-gray-100 border-t">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm">Clinic: {{ config('app.name') }}</p>
                    <p class="text-sm">Address: 123 Medical Drive, City, State ZIP</p>
                    <p class="text-sm">Phone: (123) 456-7890</p>
                </div>
                <div class="text-right">
                    <div class="border-t-2 border-black pt-2 mt-2">
                        <p class="font-semibold">Dr. {{ $prescription->doctor->name }}</p>
                        <p class="text-sm">Signature</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection