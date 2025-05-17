<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\InventoryRequest;
use App\Models\DentalSupply;
use App\Repositories\InventoryRepository;

class InventoryController extends BaseController
{
    private $inventoryRepository;

    public function __construct()
    {
        parent::__construct();
        $this->inventoryRepository = app(InventoryRepository::class);
    }

    public function index()
    {
        $supplies = $this->inventoryRepository->getAllWithPaginate(15);
        $lowStock = $this->inventoryRepository->getLowStockItems();
        
        $this->title = "Inventory Management";
        $this->content = view('admin.inventory.index', 
            compact('supplies', 'lowStock'))->render();
            
        return $this->renderOutput();
    }

    public function create()
    {
        $categories = $this->inventoryRepository->getCategories();
        $suppliers = $this->inventoryRepository->getSuppliers();
        
        $this->title = "Add New Inventory Item";
        $this->content = view('admin.inventory.create', 
            compact('categories', 'suppliers'))->render();
            
        return $this->renderOutput();
    }

    public function store(InventoryRequest $request)
    {
        $data = $request->all();
        $supply = $this->inventoryRepository->create($data);
        
        return redirect()
            ->route('admin.inventory.show', $supply->id)
            ->with(['success' => 'Inventory item added successfully']);
    }

    public function show($id)
    {
        $supply = $this->inventoryRepository->getEdit($id);
        $transactions = $supply->transactions()->latest()->paginate(10);
        
        $this->title = "Inventory Item: " . $supply->name;
        $this->content = view('admin.inventory.show', 
            compact('supply', 'transactions'))->render();
            
        return $this->renderOutput();
    }

    public function edit($id)
    {
        $supply = $this->inventoryRepository->getEdit($id);
        $categories = $this->inventoryRepository->getCategories();
        $suppliers = $this->inventoryRepository->getSuppliers();
        
        $this->title = "Edit Inventory Item: " . $supply->name;
        $this->content = view('admin.inventory.edit', 
            compact('supply', 'categories', 'suppliers'))->render();
            
        return $this->renderOutput();
    }

    public function update(InventoryRequest $request, $id)
    {
        $supply = $this->inventoryRepository->getEdit($id);
        $data = $request->all();
        
        $supply->update($data);
        
        return redirect()
            ->route('admin.inventory.show', $supply->id)
            ->with(['success' => 'Inventory item updated successfully']);
    }

    public function destroy($id)
    {
        $supply = $this->inventoryRepository->getEdit($id);
        $supply->delete();
        
        return redirect()
            ->route('admin.inventory.index')
            ->with(['success' => 'Inventory item removed']);
    }
    
    public function adjustStock(Request $request, $id)
    {
        $validated = $request->validate([
            'adjustment' => 'required|integer',
            'notes' => 'nullable|string|max:255',
        ]);
        
        $supply = $this->inventoryRepository->getEdit($id);
        $this->inventoryRepository->adjustStock(
            $supply, 
            $validated['adjustment'], 
            $validated['notes']
        );
        
        return back()->with(['success' => 'Stock adjusted successfully']);
    }
    
    public function lowStockReport()
    {
        $lowStock = $this->inventoryRepository->getLowStockItems();
        
        $this->title = "Low Stock Report";
        $this->content = view('admin.inventory.low_stock_report', 
            compact('lowStock'))->render();
            
        return $this->renderOutput();
    }
    
    public function exportInventory()
    {
        return Excel::download(new InventoryExport, 'inventory_' . now()->format('Y-m-d') . '.xlsx');
    }
}