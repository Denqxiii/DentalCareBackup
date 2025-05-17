<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    // Display all inventory items
    public function index()
    {
        $items = InventoryItem::with('movements')->paginate(10);
        return view('inventory.index', compact('items'));
    }

    // Show create form
    public function create()
    {
        return view('inventory.create');
    }

    // Store new inventory item
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'initial_quantity' => 'required|integer|min:0',
            'low_stock_threshold' => 'required|integer|min:0'
        ]);

        $item = InventoryItem::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'current_quantity' => $validated['initial_quantity'],
            'low_stock_threshold' => $validated['low_stock_threshold']
        ]);

        // Record initial stock
        $item->movements()->create([
            'type' => 'purchase',
            'quantity' => $validated['initial_quantity'],
            'notes' => 'Initial stock'
        ]);

        return redirect()->route('inventory.index');
    }

    // Show edit form
    public function edit(InventoryItem $item)
    {
        return view('inventory.edit', compact('item'));
    }

    // Update inventory item
    public function update(Request $request, InventoryItem $item)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'low_stock_threshold' => 'required|integer|min:0'
        ]);

        $item->update($validated);
        return redirect()->route('inventory.index');
    }

    // Show stock movements for an item
    public function movements(InventoryItem $item)
    {
        $movements = $item->movements()->latest()->paginate(10);
        return view('inventory.movements', compact('item', 'movements'));
    }

    // Show form to record new movement
    public function createMovement()
    {
        $items = InventoryItem::all();
        return view('inventory.movements-create', compact('items'));
    }

    // Store new stock movement
    public function storeMovement(Request $request)
    {
        $validated = $request->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'type' => 'required|in:purchase,usage,adjustment,return',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);

        $movement = StockMovement::create($validated);
        
        // Update inventory quantity
        $item = InventoryItem::find($validated['inventory_item_id']);
        if (in_array($validated['type'], ['purchase', 'return'])) {
            $item->increment('current_quantity', $validated['quantity']);
        } else {
            $item->decrement('current_quantity', $validated['quantity']);
        }

        return redirect()->route('inventory.movements', $item);
    }
}