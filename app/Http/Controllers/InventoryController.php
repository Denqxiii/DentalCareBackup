<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::query();

        if ($request->filled('search')) {
            $query->where('item_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Paginate results, 10 items per page
        $inventoryItems = $query->paginate(10);

        return view('inventory.index', compact('inventoryItems'));
    }

    public function create()
    {
        $suppliers = Supplier::all(); // Fetch all suppliers from the database
        return view('inventory.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'category' => 'required|string',
            'quantity_in_stock' => 'required|integer|min:0',
            'price_per_unit' => 'required|numeric|min:0',
            'supplier_id' => 'required|exists:suppliers,id', // Ensure the supplier exists in the suppliers table
        ]);

        // Create the inventory item
        Inventory::create([
            'item_name' => $request->item_name,
            'category' => $request->category,
            'quantity_in_stock' => $request->quantity_in_stock,
            'price_per_unit' => $request->price_per_unit,
            'supplier_id' => $request->supplier_id,
        ]);

        return redirect()->route('inventory.index')->with('success', 'Inventory item added successfully.');
    }

    public function edit($id)
    {
        $item = Inventory::findOrFail($id);
        return view('inventory.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity_in_stock' => 'required|integer',
            'price_per_unit' => 'required|numeric',
            'item_type' => 'required|in:consumable,equipment',
            'threshold' => 'required|integer',
            'expiration_date' => 'nullable|date',
            'supplier_name' => 'nullable|string|max:255',
            'status' => 'required|in:active,expired,out_of_stock',
        ]);

        $item = Inventory::findOrFail($id);
        $item->update([
            'item_name' => $request->item_name,
            'quantity_in_stock' => $request->quantity_in_stock,
            'price_per_unit' => $request->price_per_unit,
            'item_type' => $request->item_type,
            'threshold' => $request->threshold,
            'expiration_date' => $request->expiration_date,
            'supplier_name' => $request->supplier_name,
            'status' => $request->status,
        ]);

        return redirect()->route('inventory.index')->with('success', 'Item updated successfully!');
    }

    public function destroy($id)
    {
        $item = Inventory::findOrFail($id);
        $item->delete();

        return redirect()->route('inventory.index')->with('success', 'Item deleted successfully!');
    }
}
