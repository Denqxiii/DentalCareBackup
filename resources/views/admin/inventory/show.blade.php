@extends('layouts.admin')

@section('title', 'Inventory Item Details')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>{{ $item->name }}</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Category:</th>
                        <td>{{ $item->category }}</td>
                    </tr>
                    <tr>
                        <th>Current Stock:</th>
                        <td class="{{ $item->quantity <= $item->reorder_level ? 'text-danger font-weight-bold' : '' }}">
                            {{ $item->quantity }} {{ $item->unit }}
                            @if($item->quantity <= $item->reorder_level)
                                <span class="badge badge-warning">Low Stock</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Reorder Level:</th>
                        <td>{{ $item->reorder_level }} {{ $item->unit }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Unit Cost:</th>
                        <td>${{ number_format($item->unit_cost, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Supplier:</th>
                        <td>{{ $item->supplier }}</td>
                    </tr>
                    <tr>
                        <th>Last Updated:</th>
                        <td>{{ $item->updated_at->format('m/d/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <h6>Stock Adjustment</h6>
            <form action="{{ route('admin.inventory.adjust', $item->id) }}" method="POST" class="form-inline">
                @csrf
                <div class="form-group mr-2">
                    <select name="action" class="form-control">
                        <option value="add">Add Stock</option>
                        <option value="remove">Remove Stock</option>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <input type="number" name="quantity" class="form-control" placeholder="Quantity" min="1" required>
                </div>
                <div class="form-group mr-2">
                    <input type="text" name="notes" class="form-control" placeholder="Notes" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>

        <div class="mt-4">
            <h6>Transaction History</h6>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Transaction</th>
                        <th>Quantity</th>
                        <th>User</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->created_at->format('m/d/Y H:i') }}</td>
                        <td>{{ ucfirst($transaction->type) }}</td>
                        <td>{{ $transaction->quantity }} {{ $item->unit }}</td>
                        <td>{{ $transaction->user->name }}</td>
                        <td>{{ $transaction->notes }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection