@extends('layouts.admin')

@section('title', 'Appointments')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fs-4 fw-bold text-primary">Appointment Management</h1>
        <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>New Appointment
        </a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search and Filter Card -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Search & Filters</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.appointments.index') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Search by patient name">
                            <label for="search">Search Patient</label>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-floating">
                            <select class="form-select" id="treatment" name="treatment">
                                <option value="">All Treatments</option>
                                @foreach($treatments as $treatment)
                                    <option value="{{ $treatment->id }}" {{ request('treatment') == $treatment->id ? 'selected' : '' }}>
                                        {{ $treatment->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="treatment">Treatment Type</label>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-floating">
                            <select class="form-select" id="status" name="status">
                                <option value="">All Statuses</option>
                                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <label for="status">Status</label>
                        </div>
                    </div>
                    
                    <div class="col-md-2 d-flex align-items-center">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-search me-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Appointments Table Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Appointments List</h5>
                <span class="badge bg-primary rounded-pill">{{ $appointments->total() }} Total</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Patient</th>
                            <th>Date & Time</th>
                            <th>Treatment</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appt)
                            <tr>
                                <td class="ps-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-light text-primary me-2">
                                            {{ substr($appt->patient->first_name ?? '?', 0, 1) }}{{ substr($appt->patient->last_name ?? '', 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="fw-medium">{{ $appt->patient ? $appt->patient->first_name . ' ' . $appt->patient->last_name : 'N/A' }}</span>
                                            @if($appt->patient && $appt->patient->phone)
                                                <div class="small text-muted">{{ $appt->patient->phone }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-medium">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y') }}</div>
                                    <div class="small text-muted">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('h:i A') }}</div>
                                </td>
                                <td>
                                    <span class="treatment-pill">{{ $appt->treatment->name ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    @php
                                        $statusClass = 'bg-secondary';
                                        if($appt->status == 'Pending') $statusClass = 'bg-warning text-dark';
                                        elseif($appt->status == 'Completed') $statusClass = 'bg-success';
                                        elseif($appt->status == 'Cancelled') $statusClass = 'bg-danger';
                                    @endphp
                                    <span class="badge {{ $statusClass }}">{{ $appt->status }}</span>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group">
                                        @if($appt->status == 'Pending')
                                            <button type="button" class="btn btn-sm btn-success" 
                                                    onclick="confirmStatusChange('{{ route('admin.appointments.complete', $appt->id) }}', 'complete')">
                                                <i class="bi bi-check-lg me-1"></i>Complete
                                            </button>
                                            
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="confirmStatusChange('{{ route('admin.appointments.cancel', $appt->id) }}', 'cancel')">
                                                <i class="bi bi-x-lg me-1"></i>Cancel
                                            </button>
                                        @else
                                            <span class="text-muted">No actions available</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-calendar-x fs-2 d-block mb-2"></i>
                                    No appointments found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($appointments->hasPages())
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing {{ $appointments->firstItem() }} to {{ $appointments->lastItem() }} of {{ $appointments->total() }} appointments
                    </div>
                    <div>
                        {{ $appointments->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Status Change Confirmation Modal -->
<div class="modal fade" id="statusChangeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Confirm Status Change</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
                Are you sure you want to change this appointment's status?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="statusChangeForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn" id="confirmButton">Confirm</button>
                </form>
            </div>
        </div>
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
    
    .treatment-pill {
        background-color: #edf5ff;
        color: #2c80ff;
        border-radius: 30px;
        padding: 4px 12px;
        font-size: 0.875rem;
        font-weight: 500;
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
</style>
@endpush

@push('scripts')
<script>
    function confirmStatusChange(url, action) {
        const modal = new bootstrap.Modal(document.getElementById('statusChangeModal'));
        const form = document.getElementById('statusChangeForm');
        const title = document.getElementById('modalTitle');
        const body = document.getElementById('modalBody');
        const button = document.getElementById('confirmButton');
        
        form.action = url;
        
        if (action === 'complete') {
            title.textContent = 'Mark Appointment as Completed';
            body.textContent = 'Are you sure you want to mark this appointment as completed?';
            button.textContent = 'Complete';
            button.className = 'btn btn-success';
        } else if (action === 'cancel') {
            title.textContent = 'Cancel Appointment';
            body.textContent = 'Are you sure you want to cancel this appointment?';
            button.textContent = 'Cancel Appointment';
            button.className = 'btn btn-danger';
        }
        
        modal.show();
    }
</script>
@endpush
@endsection