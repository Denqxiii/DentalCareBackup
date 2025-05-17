@extends('layouts.admin')

@section('title', 'Prescriptions')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5>Prescription List</h5>
            <a href="{{ route('admin.prescriptions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prescriptions as $prescription)
                    <tr>
                        <td>{{ $prescription->id }}</td>
                        <td>{{ $prescription->patient->name }}</td>
                        <td>{{ $prescription->doctor->name }}</td>
                        <td>{{ $prescription->created_at->format('m/d/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.prescriptions.show', $prescription->id) }}" 
                               class="btn btn-sm btn-info" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.prescriptions.edit', $prescription->id) }}" 
                               class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <!-- Add delete button with form if needed -->
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No prescriptions found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $prescriptions->links() }}
        </div>
    </div>
</div>
@endsection