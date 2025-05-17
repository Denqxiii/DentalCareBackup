@extends('layouts.admin')

@section('title', 'Patient Details')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Patient Information</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Name:</strong> {{ $patient->name }}</p>
                <p><strong>Email:</strong> {{ $patient->email }}</p>
                <p><strong>Phone:</strong> {{ $patient->phone }}</p>
            </div>
        </div>
        
        <hr>
        
        <h5 class="mt-4">Appointments</h5>
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patient->appointments as $appt)
                <tr>
                    <td>{{ $appt->date->format('M d, Y h:i A') }}</td>
                    <td><span class="badge bg-{{ $appt->status == 'scheduled' ? 'primary' : 'success' }}">{{ ucfirst($appt->status) }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection