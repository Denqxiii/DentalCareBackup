@extends('admin.layouts.app')

@section('title', 'Financial Reports')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5>Financial Reports</h5>
            <div class="btn-group">
                <button class="btn btn-secondary dropdown-toggle" type="button" 
                        data-bs-toggle="dropdown">
                    Export
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">PDF</a></li>
                    <li><a class="dropdown-item" href="#">Excel</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <label>Start Date</label>
                    <input type="date" class="form-control" name="start_date">
                </div>
                <div class="col-md-3">
                    <label>End Date</label>
                    <input type="date" class="form-control" name="end_date">
                </div>
                <div class="col-md-3">
                    <label>Report Type</label>
                    <select class="form-control" name="report_type">
                        <option value="revenue">Revenue</option>
                        <option value="payments">Payments</option>
                        <option value="outstanding">Outstanding</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Total Revenue</th>
                        <th>Payments Collected</th>
                        <th>Outstanding Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($financialData as $data)
                    <tr>
                        <td>{{ $data['date'] }}</td>
                        <td>${{ number_format($data['revenue'], 2) }}</td>
                        <td>${{ number_format($data['payments'], 2) }}</td>
                        <td>${{ number_format($data['outstanding'], 2) }}</td>
                    </tr>
                    @endforeach
                    <tr class="table-active">
                        <td><strong>Totals</strong></td>
                        <td><strong>${{ number_format($totals['revenue'], 2) }}</strong></td>
                        <td><strong>${{ number_format($totals['payments'], 2) }}</strong></td>
                        <td><strong>${{ number_format($totals['outstanding'], 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <canvas id="financialChart" height="100"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('financialChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [
                {
                    label: 'Revenue',
                    data: {!! json_encode($chartRevenue) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Payments',
                    data: {!! json_encode($chartPayments) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection