@extends('layouts.app')

@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Financial Reports
    </h2>

    <!-- Filter Card -->
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form action="{{ route('reports.financial') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="flex flex-col">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-2">
                    Start Date
                </label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" 
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded-lg">
            </div>
            <div class="flex flex-col">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-2">
                    End Date
                </label>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input rounded-lg">
            </div>
            <div class="flex flex-col">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-2">
                    Report Type
                </label>
                <select name="report_type" 
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray rounded-lg">
                    <option value="revenue" {{ request('report_type') == 'revenue' ? 'selected' : '' }}>Revenue</option>
                    <option value="expenses" {{ request('report_type') == 'expenses' ? 'selected' : '' }}>Expenses</option>
                    <option value="profit" {{ request('report_type') == 'profit' ? 'selected' : '' }}>Profit Analysis</option>
                    <option value="collection" {{ request('report_type') == 'collection' ? 'selected' : '' }}>Collection Rate</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Generate Report
                </button>
            </div>
        </form>
    </div>

    <!-- Financial Summary Cards -->
    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <!-- Total Revenue Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Total Revenue
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    ${{ number_format($totalRevenue ?? 0, 2) }}
                </p>
            </div>
        </div>
        <!-- Total Outstanding Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Outstanding Amount
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    ${{ number_format($outstandingAmount ?? 0, 2) }}
                </p>
            </div>
        </div>
        <!-- Total Expenses Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Total Expenses
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    ${{ number_format($totalExpenses ?? 0, 2) }}
                </p>
            </div>
        </div>
        <!-- Net Profit Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Net Profit
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    ${{ number_format(($totalRevenue ?? 0) - ($totalExpenses ?? 0), 2) }}
                </p>
            </div>
        </div>
    </div>

    <!-- Charts Container -->
    <div class="grid gap-6 mb-8 md:grid-cols-2">
        <!-- Revenue Chart -->
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                Revenue Trend
            </h4>
            <canvas id="revenueChart"></canvas>
        </div>
        
        <!-- Expenses Chart -->
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                Expenses Breakdown
            </h4>
            <canvas id="expensesChart"></canvas>
        </div>
    </div>

    <!-- Detailed Revenue Table -->
    <div class="w-full overflow-hidden rounded-lg shadow-md mb-8">
        <h4 class="px-6 py-4 font-semibold text-gray-800 dark:text-gray-300 bg-white dark:bg-gray-800 border-b dark:border-gray-700">
            Detailed Revenue Breakdown
        </h4>
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Treatment Type</th>
                        <th class="px-4 py-3">Patient Count</th>
                        <th class="px-4 py-3">Total Revenue</th>
                        <th class="px-4 py-3">Collected Amount</th>
                        <th class="px-4 py-3">Outstanding</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse($revenueByTreatment ?? [] as $treatment)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                            {{ $treatment->name }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $treatment->patient_count }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            ${{ number_format($treatment->total_revenue, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            ${{ number_format($treatment->collected_amount, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            ${{ number_format($treatment->total_revenue - $treatment->collected_amount, 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td colspan="5" class="px-4 py-3 text-sm text-center">
                            No revenue data available for the selected period
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Expenses Table -->
    <div class="w-full overflow-hidden rounded-lg shadow-md">
        <h4 class="px-6 py-4 font-semibold text-gray-800 dark:text-gray-300 bg-white dark:bg-gray-800 border-b dark:border-gray-700">
            Expenses Breakdown
        </h4>
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Amount</th>
                        <th class="px-4 py-3">Percentage</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse($expensesByCategory ?? [] as $expense)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                            {{ $expense->category }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            ${{ number_format($expense->amount, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ number_format(($expense->amount / ($totalExpenses ?? 1)) * 100, 1) }}%
                        </td>
                    </tr>
                    @empty
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td colspan="3" class="px-4 py-3 text-sm text-center">
                            No expense data available for the selected period
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Sample data - Replace with actual data from your controller
        const revenueData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Revenue',
                backgroundColor: 'rgba(102, 126, 234, 0.5)',
                borderColor: 'rgb(102, 126, 234)',
                data: [10000, 15000, 12000, 22000, 18000, 24000, 33000, 31000, 29000, 33000, 19000, 27000],
                fill: true,
            }]
        };

        const expensesData = {
            labels: ['Equipment', 'Staff Salary', 'Dental Supplies', 'Utilities', 'Rent', 'Others'],
            datasets: [{
                label: 'Expenses',
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(255, 159, 64, 0.5)',
                    'rgba(255, 205, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(153, 102, 255, 0.5)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)'
                ],
                data: [15000, 45000, 12000, 8000, 20000, 5000],
                borderWidth: 1
            }]
        };

        // Line chart for revenue
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: revenueData,
            options: {
                responsive: true,
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

        // Pie chart for expenses
        const expensesCtx = document.getElementById('expensesChart').getContext('2d');
        new Chart(expensesCtx, {
            type: 'pie',
            data: expensesData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                const dataset = tooltipItem.dataset;
                                const total = dataset.data.reduce((previousValue, currentValue) => previousValue + currentValue);
                                const currentValue = dataset.data[tooltipItem.dataIndex];
                                const percentage = ((currentValue/total) * 100).toFixed(1);
                                return `$${currentValue} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection