@extends('admin.layouts.app')

@section('title', 'Prescriptions')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5>Prescription List</h5>
            <a href="{{ route('admin.prescriptions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Prescription
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Patient</th>
                    <th>Dentist</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prescriptions as $prescription)
                <tr>
                    <td>{{ $prescription->created_at->format('m/d/Y') }}</td>
                    <td>{{ $prescription->patient->name }}</td>
                    <td>Dr. {{ $prescription->dentist->last_name }}</td>
                    <td>
                        <a href="{{ route('admin.prescriptions.show', $prescription->id) }}" 
                           class="btn btn-sm btn-info">
                           <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection