@extends('layouts.admin')

@section('title', 'Low Stock Report')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5>Low Stock Items</h5>
            <div>
                <button class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print"></i> Print Report
                </button>
                <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Inventory
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i> 
            <strong>Warning:</strong> The following items are at or below their reorder levels.
        </div>

        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Item</th>
                    <th>Category</th>
                    <th>Current Stock</th>
                    <th>Reorder Level</th>
                    <th>Unit Cost</th>
                    <th>Supplier</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lowStockItems as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category }}</td>
                    <td class="text-danger font-weight-bold">{{ $item->quantity }} {{ $item->unit }}</td>
                    <td>{{ $item->reorder_level }} {{ $item->unit }}</td>
                    <td>${{ number_format($item->unit_cost, 2) }}</td>
                    <td>{{ $item->supplier }}</td>
                    <td>
                        <a href="{{ route('admin.inventory.edit', $item->id) }}" 
                           class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Reorder
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            <h5>Suggested Order List</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Supplier</th>
                        <th>Suggested Order Quantity</th>
                        <th>Estimated Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStockItems as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->supplier }}</td>
                        <td>{{ $item->reorder_level * 3 }} {{ $item->unit }}</td>
                        <td>${{ number_format($item->unit_cost * $item->reorder_level * 3, 2) }}</td>
                    </tr>
                    @endforeach
                    <tr class="table-active">
                        <td colspan="3" class="text-right"><strong>Total Estimated Cost:</strong></td>
                        <td><strong>${{ number_format($totalEstimatedCost, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection