@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8 py-8">
    <h2 class="text-2xl font-bold mb-6">Stock {{ ucfirst($movementType) }} for {{ $inventoryItem->item_name }}</h2>

    <form action="{{ route('stock-movements.store') }}" method="POST" class="max-w-md">
        @csrf
        <input type="hidden" name="inventory_id" value="{{ $inventoryItem->id }}">
        <input type="hidden" name="type" value="{{ $movementType }}">

        <div class="mb-4">
            <label for="quantity" class="block mb-2 font-semibold">Quantity</label>
            <input type="number" name="quantity" id="quantity" min="1" required
                class="w-full border rounded px-3 py-2"
                value="{{ old('quantity') }}">
            @error('quantity')
                <p class="text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="reason" class="block mb-2 font-semibold">Reason (optional)</label>
            <textarea name="reason" id="reason" rows="3" class="w-full border rounded px-3 py-2">{{ old('reason') }}</textarea>
            @error('reason')
                <p class="text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="px-6 py-3 bg-purple-600 text-white rounded hover:bg-purple-700">Submit</button>
        <a href="{{ route('inventory.index') }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
    </form>
</div>
@endsection
