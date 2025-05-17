@extends('layouts.admin')

@section('title', 'Patients')

@section('content')
<div class="container-fluid px-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mt-3 mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Patients</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fs-4 fw-bold text-primary">Patient Management</h1>
        <a href="{{ route('admin.patients.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>Add Patient
        </a>
    </div>
    
    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050">
        @if(session('success'))
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <i class="bi bi-check-circle me-2"></i>
                <strong class="me-auto">Success</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('success') }}
            </div>
        </div>
        @endif
    </div>

    <!-- Search card -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0"><i class="bi bi-search me-2"></i>Search Patients</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.patients.index') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Search by name, email or phone">
                            <label for="search">Search by name, email or phone</label>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-center">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-search me-1"></i>Search
                        </button>
                        <a href="{{ route('admin.patients.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Patients table card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-people me-2"></i>Patient List</h5>
                <span class="badge bg-primary rounded-pill">{{ $patients->count() }} Patients</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">ID</th>
                            <th>Patient Details</th>
                            <th>Contact Information</th>
                            <th>Appointments</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $patient)
                        <tr>
                            <td class="ps-3 align-middle">
                                <span class="fw-medium">{{ $patient->patient_id }}</span>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle bg-light text-primary me-2">
                                        {{ substr($patient->first_name ?? '?', 0, 1) }}{{ substr($patient->last_name ?? '', 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="fw-medium">{{ $patient->first_name }} {{ $patient->middle_name ? $patient->middle_name . ' ' : '' }}{{ $patient->last_name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div>
                                    @if($patient->email)
                                        <div><i class="bi bi-envelope me-1 text-muted"></i>{{ $patient->email }}</div>
                                    @endif
                                    <div><i class="bi bi-telephone me-1 text-muted"></i>{{ $patient->phone }}</div>
                                </div>
                            </td>
                            <td class="align-middle">
                                @if(isset($appointmentCounts[$patient->patient_id]))
                                    <span class="badge bg-info">{{ $appointmentCounts[$patient->patient_id] }} appointments</span>
                                @else
                                    <span class="badge bg-light text-muted">No appointments</span>
                                @endif
                            </td>
                            <td class="text-end pe-3 align-middle">
                                <div class="btn-group">
                                    <a href="{{ route('admin.patients.show', $patient->patient_id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>View
                                    </a>
                                    <a href="{{ route('admin.patients.edit', $patient->patient_id) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil me-1"></i>Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-people-slash fs-2 d-block mb-2"></i>
                                No patients found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if(isset($patients) && method_exists($patients, 'hasPages') && $patients->hasPages())
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing {{ $patients->firstItem() }} to {{ $patients->lastItem() }} of {{ $patients->total() }} patients
                    </div>
                    <div>
                        {{ $patients->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .avatar-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
        font-size: 14px;
    }
    
    .table th {
        font-weight: 600;
        white-space: nowrap;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .btn-group .btn {
        border-radius: 4px !important;
        margin: 0 2px;
    }
    
    .pagination {
        margin-bottom: 0;
    }
    
    .toast {
        min-width: 300px;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto hide toasts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const toasts = document.querySelectorAll('.toast');
        toasts.forEach(toast => {
            setTimeout(() => {
                const bsToast = bootstrap.Toast.getInstance(toast);
                if (bsToast) {
                    bsToast.hide();
                }
            }, 5000);
        });
    });
</script>
@endpush
@endsection