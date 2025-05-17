@extends('layouts.admin')

@section('title', 'Patient Details - ' . $patient->name)

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header with Actions -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.patients.index') }}">Patients</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $patient->name }}</li>
                </ol>
            </nav>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Patient Profile</h1>
        </div>
        <div>
            <a href="{{ route('admin.patients.edit', $patient->patient_id) }}"" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit Profile
            </a>
            <div class="dropdown d-inline-block ms-2">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="patientActions" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="patientActions">
                    <li><a class="dropdown-item" href="{{ route('admin.appointments.create', ['patient_id' => $patient->id]) }}"><i class="far fa-calendar-plus me-2"></i> Schedule Appointment</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.patients.show', $patient->patient_id) }}"><i class="fas fa-file-medical me-2"></i> Medical Records</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('admin.patients.destroy', $patient->patient_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this patient?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash-alt me-2"></i> Delete Patient</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Patient Information Card -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom border-light d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0">Personal Information</h5>
                    <span class="badge bg-{{ $patient->status == 'active' ? 'success' : 'secondary' }} rounded-pill">{{ ucfirst($patient->status ?? 'active') }}</span>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar-circle mx-auto mb-3">
                            @if($patient->avatar)
                                <img src="{{ $patient->avatar }}" alt="{{ $patient->name }}" class="rounded-circle img-fluid avatar-img" width="120">
                            @else
                                <div class="avatar-initials rounded-circle d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; background-color: #e9ecef; font-size: 2.5rem;">
                                    {{ substr($patient->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <h4 class="font-weight-bold mb-1">{{ $patient->name }}</h4>
                        <p class="text-muted">Patient ID: {{ $patient->id }}</p>
                    </div>

                    <div class="patient-info">
                        <div class="info-item d-flex mb-3">
                            <div class="info-icon me-3">
                                <i class="fas fa-envelope text-primary"></i>
                            </div>
                            <div class="info-content">
                                <span class="d-block text-muted small">Email</span>
                                <span>{{ $patient->email ?? 'Not provided' }}</span>
                            </div>
                        </div>
                        
                        <div class="info-item d-flex mb-3">
                            <div class="info-icon me-3">
                                <i class="fas fa-phone text-primary"></i>
                            </div>
                            <div class="info-content">
                                <span class="d-block text-muted small">Phone</span>
                                <span>{{ $patient->phone ?? 'Not provided' }}</span>
                            </div>
                        </div>
                        
                        <div class="info-item d-flex mb-3">
                            <div class="info-icon me-3">
                                <i class="fas fa-birthday-cake text-primary"></i>
                            </div>
                            <div class="info-content">
                                <span class="d-block text-muted small">Date of Birth</span>
                                <span>{{ $patient->dob ? $patient->dob->format('M d, Y') : 'Not provided' }}</span>
                            </div>
                        </div>
                        
                        <div class="info-item d-flex mb-3">
                            <div class="info-icon me-3">
                                <i class="fas fa-map-marker-alt text-primary"></i>
                            </div>
                            <div class="info-content">
                                <span class="d-block text-muted small">Address</span>
                                <span>{{ $patient->address ?? 'Not provided' }}</span>
                            </div>
                        </div>
                        
                        <div class="info-item d-flex mb-3">
                            <div class="info-icon me-3">
                                <i class="fas fa-venus-mars text-primary"></i>
                            </div>
                            <div class="info-content">
                                <span class="d-block text-muted small">Gender</span>
                                <span>{{ ucfirst($patient->gender ?? 'Not specified') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Appointments and Stats -->
        <div class="col-lg-8">
            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Total Appointments</h6>
                                    <h3 class="mb-0">{{ $patient->appointments->count() }}</h3>
                                </div>
                                <div class="rounded-circle bg-light p-3">
                                    <i class="fas fa-calendar text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Upcoming Appointments</h6>
                                    <h3 class="mb-0">{{ $patient->appointments->where('date', '>=', now())->where('status', 'scheduled')->count() }}</h3>
                                </div>
                                <div class="rounded-circle bg-light p-3">
                                    <i class="fas fa-calendar-check text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Last Visit</h6>
                                    <h3 class="mb-0">{{ $patient->appointments->where('status', 'completed')->sortByDesc('date')->first() ? $patient->appointments->where('status', 'completed')->sortByDesc('date')->first()->date->diffForHumans() : 'Never' }}</h3>
                                </div>
                                <div class="rounded-circle bg-light p-3">
                                    <i class="fas fa-history text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Appointments Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom border-light d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0">Appointment History</h5>
                    <a href="{{ route('admin.appointments.create', ['patient_id' => $patient->id]) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i> New Appointment
                    </a>
                </div>
                <div class="card-body">
                    @if($patient->appointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Date & Time</th>
                                        <th>Purpose</th>
                                        <th>Doctor</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($patient->appointments->sortByDesc('date') as $appt)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="calendar-icon text-center me-3">
                                                    <div class="calendar-month bg-primary text-white small px-1 rounded-top">{{ $appt->date->format('M') }}</div>
                                                    <div class="calendar-day bg-light px-2 rounded-bottom fw-bold">{{ $appt->date->format('d') }}</div>
                                                </div>
                                                <span>{{ $appt->date->format('h:i A') }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $appt->purpose ?? 'General Checkup' }}</td>
                                        <td>{{ $appt->doctor->name ?? 'Not assigned' }}</td>
                                        <td>
                                            @php
                                                $statusClass = match($appt->status) {
                                                    'scheduled' => 'primary',
                                                    'completed' => 'success',
                                                    'cancelled' => 'danger',
                                                    'missed' => 'warning',
                                                    default => 'secondary'
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $statusClass }}">{{ ucfirst($appt->status) }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.appointments.show', $appt->id) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.appointments.edit', $appt->id) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-calendar-times fa-4x text-muted"></i>
                            </div>
                            <h5>No Appointment History</h5>
                            <p class="text-muted">This patient doesn't have any appointments yet.</p>
                            <a href="{{ route('admin.appointments.create', ['patient_id' => $patient->id]) }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Schedule First Appointment
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Medical Records & Notes -->
    <div class="row mt-4">
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom border-light d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0">Medical Records</h5>
                    <a href="{{ route('admin.records.create', ['patient_id' => $patient->id]) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-plus me-1"></i> Add Record
                    </a>
                </div>
                <div class="card-body">
                    @if(isset($patient->medicalRecords) && $patient->medicalRecords->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($patient->medicalRecords->sortByDesc('created_at')->take(5) as $record)
                                <a href="{{ route('admin.records.show', $record->id) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $record->title }}</h6>
                                        <small>{{ $record->created_at->format('M d, Y') }}</small>
                                    </div>
                                    <p class="mb-1 text-truncate">{{ $record->description }}</p>
                                    <div>
                                        <span class="badge bg-light text-dark me-1">
                                            <i class="fas fa-file-pdf me-1"></i>
                                            {{ $record->type }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        @if($patient->medicalRecords->count() > 5)
                            <div class="text-center mt-3">
                                <a href="{{ route('admin.patients.records', $patient->id) }}" class="text-decoration-none">View All Records</a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <div class="mb-3">
                                <i class="fas fa-file-medical fa-3x text-muted"></i>
                            </div>
                            <p class="text-muted">No medical records found for this patient.</p>
                            <a href="{{ route('admin.records.create', ['patient_id' => $patient->id]) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-plus me-1"></i> Add First Record
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom border-light d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0">Notes</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                        <i class="fas fa-plus me-1"></i> Add Note
                    </button>
                </div>
                <div class="card-body">
                    @if(isset($patient->notes) && $patient->notes->count() > 0)
                        <div class="timeline">
                            @foreach($patient->notes->sortByDesc('created_at') as $note)
                                <div class="timeline-item mb-3 pb-3 border-bottom">
                                    <div class="d-flex justify-content-between mb-2">
                                        <strong>{{ $note->created_by }}</strong>
                                        <small class="text-muted">{{ $note->created_at->format('M d, Y h:i A') }}</small>
                                    </div>
                                    <p class="mb-1">{{ $note->content }}</p>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-sm btn-link text-danger p-0" 
                                                onclick="if(confirm('Are you sure you want to delete this note?')) document.getElementById('delete-note-{{ $note->id }}').submit();">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <form id="delete-note-{{ $note->id }}" action="{{ route('admin.notes.destroy', $note->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="mb-3">
                                <i class="fas fa-sticky-note fa-3x text-muted"></i>
                            </div>
                            <p class="text-muted">No notes have been added for this patient.</p>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                                <i class="fas fa-plus me-1"></i> Add First Note
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Note Modal -->
<div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.patients.notes.store', $patient) }}" method="POST">
                @csrf
                <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="addNoteModalLabel">Add Patient Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="note-content" class="form-label">Note Content</label>
                        <textarea class="form-control" id="note-content" name="content" rows="4" required></textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Note</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .avatar-circle {
        width: 120px;
        height: 120px;
        overflow: hidden;
    }
    
    .info-icon {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .calendar-icon {
        min-width: 40px;
    }
    
    .timeline-item:last-child {
        border-bottom: none !important;
        padding-bottom: 0 !important;
        margin-bottom: 0 !important;
    }
</style>
@endpush

@endsection