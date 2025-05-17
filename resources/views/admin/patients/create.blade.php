@extends('layouts.admin')

@section('title', 'Add Patient')

@section('content')
<div class="container-fluid px-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mt-3 mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.patients.index') }}">Patients</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add New Patient</li>
        </ol>
    </nav>

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

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-plus fs-4 me-2 text-primary"></i>
                        <h5 class="mb-0">Add New Patient</h5>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.patients.store') }}" id="patientForm">
                        @csrf
                        
                        <div class="row g-3">
                            <!-- Personal Information -->
                            <div class="col-12">
                                <h6 class="text-muted fw-bold mb-3 border-bottom pb-2">Personal Information</h6>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                           id="first_name" name="first_name" value="{{ old('first_name') }}" 
                                           placeholder="First name" required>
                                    <label for="first_name">First Name <span class="text-danger">*</span></label>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('middle_name') is-invalid @enderror" 
                                           id="middle_name" name="middle_name" value="{{ old('middle_name') }}" 
                                           placeholder="Middle name">
                                    <label for="middle_name">Middle Name (Optional)</label>
                                    @error('middle_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                           id="last_name" name="last_name" value="{{ old('last_name') }}" 
                                           placeholder="Last name" required>
                                    <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Contact Information -->
                            <div class="col-12 mt-4">
                                <h6 class="text-muted fw-bold mb-3 border-bottom pb-2">Contact Information</h6>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" 
                                           placeholder="Email address">
                                    <label for="email">Email Address</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">Email is optional but recommended for appointment reminders</div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone') }}" 
                                           placeholder="Phone number" required>
                                    <label for="phone">Phone Number <span class="text-danger">*</span></label>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Address Information (Optional) -->
                            <div class="col-12 mt-4">
                                <h6 class="text-muted fw-bold mb-3 border-bottom pb-2">Address Information (Optional)</h6>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                           id="address" name="address" value="{{ old('address') }}" 
                                           placeholder="Street address">
                                    <label for="address">Street Address</label>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                           id="city" name="city" value="{{ old('city') }}" 
                                           placeholder="City">
                                    <label for="city">City</label>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                           id="state" name="state" value="{{ old('state') }}" 
                                           placeholder="State">
                                    <label for="state">State</label>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('zip') is-invalid @enderror" 
                                           id="zip" name="zip" value="{{ old('zip') }}" 
                                           placeholder="ZIP code">
                                    <label for="zip">ZIP Code</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-4 pt-2 border-top">
                            <a href="{{ route('admin.patients.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="bi bi-x-circle me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Save Patient
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Help Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="fw-bold text-primary"><i class="bi bi-person-badge me-2"></i>Patient Records</h6>
                        <p class="text-muted">Complete all required fields marked with <span class="text-danger">*</span>. Proper record-keeping ensures better patient care.</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="fw-bold text-primary"><i class="bi bi-calendar-check me-2"></i>Appointments</h6>
                        <p class="text-muted">After creating a patient record, you can schedule appointments from the patient details page.</p>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="bi bi-lightbulb me-2"></i>
                        <strong>Tip:</strong> Adding an email address enables automated appointment reminders.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-floating > .form-control::placeholder {
        color: transparent;
    }
    
    .form-floating > label {
        z-index: 3;
    }
    
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
        
        // Form validation example (can be expanded)
        const form = document.getElementById('patientForm');
        if (form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        }
    });
</script>
@endpush
@endsection