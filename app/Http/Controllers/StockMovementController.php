<?php

    namespace App\Http\Controllers;

    use App\Models\Inventory;
    use App\Models\StockMovement;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class StockMovementController extends Controller
    {

        // Show all stock movements for a specific inventory item
        public function index()
        {
            $stockMovements = StockMovement::with('inventory')->paginate(10);
            return view('stock-movements.index', compact('stockMovements'));
        }

        // Show form to edit stock movement

        // Show form to create stock movement
        public function create(Request $request)
        {
            $inventoryId = $request->query('inventory_id');
            $movementType = $request->query('movement_type');
            $inventory = Inventory::findOrFail($inventoryId);

            return view('stock-movements.create', compact('inventory', 'movementType'));
        }

        // Store new stock movement and update inventory quantity
        public function store(Request $request)
        {
            $request->validate([
                'inventory_id' => 'required|exists:inventory_items,id',
                'type' => 'required|in:in,out,adjustment',
                'quantity' => 'required|numeric|min:1',
                'reason' => 'nullable|string|max:255',
            ]);

            $inventoryItem = Inventory::findOrFail($request->inventory_id);
            $quantity = $request->quantity;
            $type = $request->type;

            // Adjust stock quantity depending on movement type
            if ($type === 'in') {
                $inventoryItem->quantity_in_stock += $quantity;
            } elseif ($type === 'out') {
                if ($inventoryItem->quantity_in_stock < $quantity) {
                    return back()->withErrors(['quantity' => 'Insufficient stock to remove.']);
                }
                $inventoryItem->quantity_in_stock -= $quantity;
            } elseif ($type === 'adjustment') {
                // Adjustment can be positive or negative, so quantity can be signed
                // But your input is positive number, maybe add a +/- option? 
                // For now let's assume only positive adjustment adds stock:
                $inventoryItem->quantity_in_stock += $quantity;
            }

            $inventoryItem->save();

            StockMovement::create([
                'inventory_id' => $inventoryItem->id,
                'type' => $type,
                'quantity' => $quantity,
                'reason' => $request->reason,
                'performed_by' => Auth::id() ?? null, // or some user id
            ]);

            return redirect()->route('inventory.index')->with('success', 'Stock updated successfully.');
        }
    }
