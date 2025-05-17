@extends('admin.layouts.app')

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
                @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->created_at->format('m/d/Y') }}</td>
                    <td>{{ $payment->invoice->patient->name }}</td>
                    <td>${{ number_format($payment->amount, 2) }}</td>
                    <td>{{ ucfirst($payment->method) }}</td>
                    <td>#{{ $payment->invoice->invoice_number }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-info">
                            <i class="fas fa-receipt"></i> Receipt
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection