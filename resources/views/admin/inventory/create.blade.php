@extends('admin.layouts.app')

@section('title', 'Add Inventory Item')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Add New Inventory Item</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.inventory.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Item Name *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category">Category *</label>
                        <select class="form-control" id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="Dental Materials">Dental Materials</option>
                            <option value="Medicines">Medicines</option>
                            <option value="Consumables">Consumables</option>
                            <option value="Equipment">Equipment</option>
                            <option value="Office Supplies">Office Supplies</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="quantity">Current Quantity *</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="unit">Unit *</label>
                        <select class="form-control" id="unit" name="unit" required>
                            <option value="pcs">Pieces</option>
                            <option value="box">Boxes</option>
                            <option value="pack">Packs</option>
                            <option value="bottle">Bottles</option>
                            <option value="tube">Tubes</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="reorder_level">Reorder Level *</label>
                        <input type="number" class="form-control" id="reorder_level" name="reorder_level" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="unit_cost">Unit Cost ($) *</label>
                        <input type="number" step="0.01" class="form-control" id="unit_cost" name="unit_cost" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="supplier">Supplier *</label>
                        <input type="text" class="form-control" id="supplier" name="supplier" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save Item</button>
        </form>
    </div>
</div>
@endsection