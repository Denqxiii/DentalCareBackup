@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Item</h2>

    <form action="{{ route('inventory.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="item_name">Item Name</label>
            <input type="text" class="form-control" id="item_name" name="item_name" value="{{ $item->item_name }}" required>
        </div>
        <div class="form-group">
            <label for="quantity_in_stock">Quantity in Stock</label>
            <input type="number" class="form-control" id="quantity_in_stock" name="quantity_in_stock" value="{{ $item->quantity_in_stock }}" required>
        </div>
        <div class="form-group">
            <label for="price_per_unit">Price per Unit</label>
            <input type="number" step="0.01" class="form-control" id="price_per_unit" name="price_per_unit" value="{{ $item->price_per_unit }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Item</button>
    </form>
</div>
@endsection
