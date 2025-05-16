@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h1 class="mb-0">Treatment Report</h1>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <form method="GET" action="{{ route('reports.treatment_report') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="treatment_id" class="form-label">Filter by Treatment</label>
                        <select name="treatment_id" id="treatment_id" class="form-select">
                            <option value="">All Treatments</option>
                            @foreach($allTreatments as $t)
                                <option value="{{ $t->id }}" {{ request('treatment_id') == $t->id ? 'selected' : '' }}>
                                    {{ $t->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>
            </div>
        <!-- Summary Statistics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Treatments</h5>
                        <h2 class="mb-0">{{ $treatments->count() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Completed</h5>
                        <h2 class="mb-0">{{ $treatments->where('status', 'completed')->count() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">Scheduled</h5>
                        <h2 class="mb-0">{{ $treatments->where('status', 'scheduled')->count() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title">Cancelled</h5>
                        <h2 class="mb-0">{{ $treatments->where('status', 'cancelled')->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>

        @if($treatments->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Patient ID</th>
                            <th>Patient Name</th>
                            <th>Treatment</th>
                            <th>Treatment Price</th>
                            <th>Procedure Date</th>
                            <th>Status</th>
                            <th>Bill Number</th>
                            <th>Payment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($treatments as $appointment)
                            <tr>
                                <td>{{ $appointment->patient->patient_id }}</td>
                                <td>{{ $appointment->patient->last_name }}, {{ $appointment->patient->first_name }}</td>
                                <td>{{ $appointment->treatment->name }}</td>
                                <td>{{ number_format($appointment->treatment->price, 2) }}</td>
                                <td>{{ $appointment->appointment_date->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $appointment->status == 'completed' ? 'success' : ($appointment->status == 'cancelled' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($appointment->bill)
                                        {{ $appointment->bill->bill_number }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
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
                    </tbody>
                    <tfoot>
                        <tr class="table-dark">
                            <td colspan="3" class="text-end"><strong>Total Value:</strong></td>
                            <td colspan="5"><strong>{{ number_format($treatments->sum(function($t) { return $t->treatment->price; }), 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="d-flex justify-content-end mt-3">
                <button onclick="window.print()" class="btn btn-secondary me-2">
                    <i class="fa fa-print"></i> Print Report
                </button>
                <a href="{{ route('reports.treatment_report', ['export' => 'pdf'] + request()->all()) }}" class="btn btn-danger">
                    <i class="fa fa-file-pdf"></i> Export PDF
                </a>
            </div>
        @else
            <div class="alert alert-info">
                No treatment records found for the selected criteria.
            </div>
        @endif
    </div>
</div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#treatment_id').select2({
            placeholder: 'Select a treatment',
            allowClear: true
        });
    });
</script>
@endpush