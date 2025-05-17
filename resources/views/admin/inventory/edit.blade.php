@extends('admin.layouts.app')

@section('title', 'Edit Inventory Item')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit Inventory Item</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.inventory.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Item Name *</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="{{ $item->name }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category">Category *</label>
                        <select class="form-control" id="category" name="category" required>
                            <option value="Dental Materials" {{ $item->category == 'Dental Materials' ? 'selected' : '' }}>Dental Materials</option>
                            <option value="Medicines" {{ $item->category == 'Medicines' ? 'selected' : '' }}>Medicines</option>
                            <option value="Consumables" {{ $item->category == 'Consumables' ? 'selected' : '' }}>Consumables</option>
                            <option value="Equipment" {{ $item->category == 'Equipment' ? 'selected' : '' }}>Equipment</option>
                            <option value="Office Supplies" {{ $item->category == 'Office Supplies' ? 'selected' : '' }}>Office Supplies</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="quantity">Current Quantity *</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" 
                               value="{{ $item->quantity }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="unit">Unit *</label>
                        <select class="form-control" id="unit" name="unit" required>
                            <option value="pcs" {{ $item->unit == 'pcs' ? 'selected' : '' }}>Pieces</option>
                            <option value="box" {{ $item->unit == 'box' ? 'selected' : '' }}>Boxes</option>
                            <option value="pack" {{ $item->unit == 'pack' ? 'selected' : '' }}>Packs</option>
                            <option value="bottle" {{ $item->unit == 'bottle' ? 'selected' : '' }}>Bottles</option>
                            <option value="tube" {{ $item->unit == 'tube' ? 'selected' : '' }}>Tubes</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="reorder_level">Reorder Level *</label>
                        <input type="number" class="form-control" id="reorder_level" name="reorder_level" 
                               value="{{ $item->reorder_level }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="unit_cost">Unit Cost ($) *</label>
                        <input type="number" step="0.01" class="form-control" id="unit_cost" name="unit_cost" 
                               value="{{ $item->unit_cost }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="supplier">Supplier *</label>
                        <input type="text" class="form-control" id="supplier" name="supplier" 
                               value="{{ $item->supplier }}" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea class="form-control" id="notes" name="notes" rows="3">{{ $item->notes }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Item</button>
        </form>
    </div>
</div>
@endsection