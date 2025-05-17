@extends('admin.layouts.app')

@section('title', 'Reports Dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Clinic Reports</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-dollar-sign fa-3x text-primary mb-3"></i>
                        <h5>Financial Reports</h5>
                        <p>Revenue, payments, and outstanding balances</p>
                        <a href="{{ route('admin.reports.financial') }}" class="btn btn-outline-primary">
                            View Reports <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-user-injured fa-3x text-success mb-3"></i>
                        <h5>Patient Reports</h5>
                        <p>Demographics and treatment history</p>
                        <a href="{{ route('admin.reports.patients') }}" class="btn btn-outline-success">
                            View Reports <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-check fa-3x text-info mb-3"></i>
                        <h5>Appointment Reports</h5>
                        <p>Scheduling and completion analytics</p>
                        <a href="{{ route('admin.reports.appointments') }}" class="btn btn-outline-info">
                            View Reports <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6>Quick Stats</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="p-3 bg-light rounded">
                                    <h4>{{ $stats['patients'] }}</h4>
                                    <small>Total Patients</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-3 bg-light rounded">
                                    <h4>{{ $stats['appointments'] }}</h4>
                                    <small>Today's Appointments</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-3 bg-light rounded">
                                    <h4>${{ number_format($stats['revenue'], 0) }}</h4>
                                    <small>Monthly Revenue</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6>Recent Activity</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach($recentActivities as $activity)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $activity->description }}
                                <span class="badge bg-secondary rounded-pill">
                                    {{ $activity->created_at->diffForHumans() }}
                                </span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection