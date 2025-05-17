@extends('layouts.admin')

@section('title', 'Inventory Management')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5>Dental Supplies Inventory</h5>
            <div>
                <a href="{{ route('admin.inventory.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Item
                </a>
                <a href="{{ route('admin.inventory.low_stock') }}" class="btn btn-warning">
                    <i class="fas fa-exclamation-triangle"></i> Low Stock
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Item</th>
                        <th>Category</th>
                        <th>Current Stock</th>
                        <th>Reorder Level</th>
                        <th>Unit Cost</th>
                        <th>Supplier</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr class="{{ $item->quantity <= $item->reorder_level ? 'table-warning' : '' }}">
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->category }}</td>
                        <td>{{ $item->quantity }} {{ $item->unit }}</td>
                        <td>{{ $item->reorder_level }} {{ $item->unit }}</td>
                        <td>${{ number_format($item->unit_cost, 2) }}</td>
                        <td>{{ $item->supplier }}</td>
                        <td>
                            <a href="{{ route('admin.inventory.show', $item->id) }}" 
                               class="btn btn-sm btn-info" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.inventory.edit', $item->id) }}" 
                               class="btn btn-sm btn-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection