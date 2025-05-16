@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h1 class="mb-0">Patient History Report</h1>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <form method="GET" action="{{ route('reports.patient') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="patient_id" class="form-label">Filter by Patient</label>
                        <select name="patient_id" id="patient_id" class="form-select">
                            <option value="">All Patients</option>
                            @foreach($allPatients as $p)
                                <option value="{{ $p->patient_id }}" {{ request('patient_id') == $p->patient_id ? 'selected' : '' }}>
                                    {{ $p->last_name }}, {{ $p->first_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>
            </div>
        @if($patients->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Patient ID</th>
                            <th>Patient Name</th>
                            <th>Treatment</th>
                            <th>Appointment Date</th>
                            <th>Appointment Time</th>
                            <th>Status</th>
                            <th>Notes</th>
                            <th>Bill Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patients as $patient)
                            @foreach ($patient->appointments as $appointment)
                                <tr>
                                    <td>{{ $patient->patient_id }}</td>
                                    <td>{{ $patient->last_name }}, {{ $patient->first_name }} {{ $patient->middle_name ? $patient->middle_name[0].'.' : '' }}</td>
                                    <td>{{ $appointment->treatment ? $appointment->treatment->name : 'N/A' }}</td>
                                    <td>{{ $appointment->appointment_date->format('M d, Y') }}</td>
                                    <td>{{ $appointment->appointment_time }}</td>
                                    <td>
                                        <span class="badge bg-{{ $appointment->status == 'completed' ? 'success' : ($appointment->status == 'cancelled' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $appointment->notes ?? 'No notes' }}</td>
                                    <td>
                                        @if($appointment->bill)
                                            <span class="badge bg-{{ $appointment->bill->status == 'paid' ? 'success' : ($appointment->bill->status == 'partial' ? 'info' : 'warning') }}">
                                                {{ ucfirst($appointment->bill->status) }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">No Bill</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end mt-3">
                <button onclick="window.print()" class="btn btn-secondary me-2">
                    <i class="fa fa-print"></i> Print Report
                </button>
                <a href="{{ route('reports.patient', ['export' => 'pdf'] + request()->all()) }}" class="btn btn-danger">
                    <i class="fa fa-file-pdf"></i> Export PDF
                </a>
            </div>
        @else
            <div class="alert alert-info">
                No patient history records found for the selected criteria.
            </div>
        @endif
    </div>
</div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#patient_id').select2({
            placeholder: 'Select a patient',
            allowClear: true
        });
    });
</script>
@endpush