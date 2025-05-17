@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    @if(isset($error))
        <div class="alert alert-danger">
            <h4><i class="fas fa-exclamation-triangle"></i> Error</h4>
            <p>{{ $error }}</p>
            <hr>
            <p class="mb-0">Please check the following:</p>
            <ul>
                <li>Make sure all required model classes are created: Patient, Appointment, Payment, and InventoryItem</li>
                <li>Run <code>composer dump-autoload</code> to refresh the autoloader</li>
                <li>Check your database connection and run migrations</li>
            </ul>
        </div>
    @else
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Dashboard</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Appointments Summary Card -->
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box bg-info">
                                <span class="info-box-icon"><i class="far fa-calendar"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Today's Appointments</span>
                                    <span class="info-box-number">{{ $todaysAppointments ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Patients Summary Card -->
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box bg-success">
                                <span class="info-box-icon"><i class="fas fa-user-injured"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Patients</span>
                                    <span class="info-box-number">{{ $totalPatients ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payments Summary Card -->
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box bg-warning">
                                <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Monthly Revenue</span>
                                    <span class="info-box-number">{{ $monthlyRevenue ?? '$0.00' }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Inventory Summary Card -->
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box bg-danger">
                                <span class="info-box-icon"><i class="fas fa-pills"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Low Stock Items</span>
                                    <span class="info-box-number">{{ $lowStockItems ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <!-- Upcoming Appointments -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Upcoming Appointments</h3>
                                </div>
                                <div class="card-body">
                                    @if(isset($upcomingAppointments) && count($upcomingAppointments) > 0)
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Patient</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Type</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($upcomingAppointments as $appointment)
                                                    <tr>
                                                        <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
                                                        <td>{{ $appointment->appointment_date->format('m/d/Y') ?? 'N/A' }}</td>
                                                        <td>{{ $appointment->appointment_time ?? 'N/A' }}</td>
                                                        <td>{{ $appointment->type ?? 'N/A' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p>No upcoming appointments.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Recent Payments -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Recent Payments</h3>
                                </div>
                                <div class="card-body">
                                    @if(isset($recentPayments) && count($recentPayments) > 0)
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Patient</th>
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($recentPayments as $payment)
                                                    <tr>
                                                        <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
                                                        <td>${{ $payment->amount ?? '0.00' }}</td>
                                                        <td>{{ $appointment->appointment_date->format('m/d/Y') ?? 'N/A' }}</td>
                                                        <td>
                                                            <span class="badge badge-{{ $payment->status == 'Paid' ? 'success' : 'warning' }}">
                                                                {{ $payment->status ?? 'N/A' }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p>No recent payments.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection