@extends('admin.layouts.app')

@section('title', 'Appointments')

@section('content')
<div class="d-flex justify-content-between mb-4">
    <h4>Appointment List</h4>
    <a href="/admin/appointments/create" class="btn btn-primary">
        <i class="bi bi-plus"></i> Schedule Appointment
    </a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Patient</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($appointments as $appt)
        <tr>
            <td>{{ $appt->patient->name }}</td>
            <td>{{ $appt->date->format('M d, Y h:i A') }}</td>
            <td><span class="badge bg-{{ $appt->status == 'scheduled' ? 'primary' : 'success' }}">{{ ucfirst($appt->status) }}</span></td>
            <td>
                <button class="btn btn-sm btn-success">
                    <i class="bi bi-check"></i> Complete
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection