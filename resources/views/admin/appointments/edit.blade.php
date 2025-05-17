@extends('layouts.admin') {{-- or whatever your main layout is --}}

@section('title', 'Edit Appointment')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mt-3 mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Appointment</li>
        </ol>
    </nav>

    <h1>Edit Appointment</h1>

    <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- example fields -->
        <div class="mb-3">
            <label for="patient_name" class="form-label">Patient Name</label>
            <input type="text" class="form-control" id="patient_name" name="patient_name" value="{{ old('patient_name', $appointment->patient_name) }}">
        </div>

        <div class="mb-3">
            <label for="appointment_date" class="form-label">Appointment Date</label>
            <input type="datetime-local" class="form-control" id="appointment_date" name="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d\TH:i')) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Appointment</button>
    </form>
@endsection
