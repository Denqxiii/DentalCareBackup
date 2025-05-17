@extends('layouts.admin')

@section('title', 'Payments')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Payment Records</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Patient</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Invoice</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->completed_at ? $appointment->completed_at->format('m/d/Y') : $appointment->updated_at->format('m/d/Y') }}</td>
                        <td>{{ $appointment->patient->name ?? 'No patient' }}</td>
                        <td>${{ number_format($appointment->invoice->amount_due ?? 0, 2) }}</td>
                        <td>Pending Payment</td>
                        <td>#{{ $appointment->invoice->invoice_number ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('admin.payments.create', ['appointment' => $appointment->id]) }}" class="btn btn-sm btn-primary">
                                Pay Now
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No unpaid completed appointments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection