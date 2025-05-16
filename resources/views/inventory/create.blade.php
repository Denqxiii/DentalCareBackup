@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8 max-w-lg mx-auto bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-white">Add New Inventory Item</h2>

        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('inventory.store') }}">
            @csrf

            <label for="item_name" class="block text-gray-700 dark:text-gray-300">Item Name</label>
            <input type="text" name="item_name" id="item_name" value="{{ old('item_name') }}"
                class="w-full mb-4 px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white"
                required>

            <label for="category" class="block text-gray-700 dark:text-gray-300">Category</label>
            <select name="category" id="category"
                class="w-full mb-4 px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white"
                required>
                <option value="" disabled selected>Select category</option>
                <option value="dental" {{ old('category') == 'dental' ? 'selected' : '' }}>Dental</option>
                <option value="hygiene" {{ old('category') == 'hygiene' ? 'selected' : '' }}>Hygiene</option>
                <option value="tools" {{ old('category') == 'tools' ? 'selected' : '' }}>Tools</option>
            </select>

            <label for="supplier" class="block text-gray-700 dark:text-gray-300">Supplier</label>
            <select name="supplier_id" id="supplier"
                class="w-full mb-4 px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white"
                required>
                <option value="" disabled selected>Select supplier</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>

            <label for="quantity_in_stock" class="block text-gray-700 dark:text-gray-300">Quantity In Stock</label>
            <input type="number" name="quantity_in_stock" id="quantity_in_stock" value="{{ old('quantity_in_stock') }}"
                min="0"
                class="w-full mb-4 px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white"
                required>

            <label for="price_per_unit" class="block text-gray-700 dark:text-gray-300">Price Per Unit (₱)</label>
            <input type="number" step="0.01" name="price_per_unit" id="price_per_unit" value="{{ old('price_per_unit') }}"
                min="0"
                class="w-full mb-6 px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white"
                required>

            <button type="submit"
                style="background-color: #4CAF50;"
                class="w-full py-3 bg-green-600 text-white rounded-md hover:bg-green-700 focus:ring-4 focus:ring-purple-300 focus:outline-none transition">
                Add Item
            </button>
        </form>
    </div>
</div>
@endsection
