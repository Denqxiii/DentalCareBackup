@extends('admin.layouts.app')

@section('title', 'Financial Reports')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5>Financial Reports</h5>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown">
                    <i class="fas fa-download"></i> Export
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">PDF</a></li>
                    <li><a class="dropdown-item" href="#">Excel</a></li>
                    <li><a class="dropdown-item" href="#">CSV</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form class="mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Report Type</label>
                    <select class="form-select" name="report_type">
                        <option value="revenue">Revenue Report</option>
                        <option value="payments">Payments Report</option>
                        <option value="outstanding">Outstanding Balances</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">From Date</label>
                    <input type="date" class="form-control" name="start_date">
                </div>
                <div class="col-md-3">
                    <label class="form-label">To Date</label>
                    <input type="date" class="form-control" name="end_date">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        Generate Report
                    </button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th class="text-end">Invoices</th>
                        <th class="text-end">Payments</th>
                        <th class="text-end">Outstanding</th>
                        <th class="text-end">Total Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($financialData as $row)
                    <tr>
                        <td>{{ $row['date'] }}</td>
                        <td class="text-end">{{ $row['invoices'] }}</td>
                        <td class="text-end">${{ number_format($row['payments'], 2) }}</td>
                        <td class="text-end">${{ number_format($row['outstanding'], 2) }}</td>
                        <td class="text-end">${{ number_format($row['revenue'], 2) }}</td>
                    </tr>
                    @endforeach
                    <tr class="table-active fw-bold">
                        <td>Totals</td>
                        <td class="text-end">{{ $totals['invoices'] }}</td>
                        <td class="text-end">${{ number_format($totals['payments'], 2) }}</td>
                        <td class="text-end">${{ number_format($totals['outstanding'], 2) }}</td>
                        <td class="text-end">${{ number_format($totals['revenue'], 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6>Payment Methods</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="paymentMethodChart" height="250"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6>Revenue Trend</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueTrendChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Payment Method Chart
    const paymentCtx = document.getElementById('paymentMethodChart').getContext('2d');
    new Chart(paymentCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($paymentMethods['labels']) !!},
            datasets: [{
                data: {!! json_encode($paymentMethods['data']) !!},
                backgroundColor: [
                    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'
                ]
            }]
        }
    });

    // Revenue Trend Chart
    const revenueCtx = document.getElementById('revenueTrendChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($revenueTrend['labels']) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($revenueTrend['data']) !!},
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderColor: '#4e73df',
                pointBackgroundColor: '#4e73df',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#4e73df'
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
@endsection