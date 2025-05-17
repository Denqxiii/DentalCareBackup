@extends('admin.layouts.app')

@section('title', 'Schedule Appointment')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Schedule New Appointment</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/admin/appointments">
            @csrf
            <div class="mb-3">
                <label class="form-label">Patient</label>
                <select class="form-select" name="patient_id" required>
                    @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Date & Time</label>
                <input type="datetime-local" class="form-control" name="date" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Notes</label>
                <textarea class="form-control" name="notes"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Schedule</button>
        </form>
    </div>
</div>
@endsection