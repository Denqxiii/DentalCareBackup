@extends('admin.layouts.app')

@section('title', 'Patient Reports')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Patient Statistics</h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5>Total Patients</h5>
                        <h2>{{ $stats['total_patients'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5>New This Month</h5>
                        <h2>{{ $stats['new_this_month'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h5>Active Patients</h5>
                        <h2>{{ $stats['active_patients'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h5>No-Shows</h5>
                        <h2>{{ $stats['no_shows'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6>Patient Demographics</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="genderChart" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6>Age Distribution</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="ageChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h6>Patient Activity</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Last Visit</th>
                            <th>Total Visits</th>
                            <th>Total Spent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activePatients as $patient)
                        <tr>
                            <td>{{ $patient->name }}</td>
                            <td>{{ $patient->last_visit->format('m/d/Y') }}</td>
                            <td>{{ $patient->visit_count }}</td>
                            <td>${{ number_format($patient->total_spent, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Gender Chart
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    new Chart(genderCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($genderLabels) !!},
            datasets: [{
                data: {!! json_encode($genderData) !!},
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(255, 206, 86, 0.7)'
                ]
            }]
        }
    });

    // Age Chart
    const ageCtx = document.getElementById('ageChart').getContext('2d');
    new Chart(ageCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($ageLabels) !!},
            datasets: [{
                label: 'Patients',
                data: {!! json_encode($ageData) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.7)'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection