<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory;
use App\Models\Supplier;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch some suppliers to associate with inventory items
        $suppliers = Supplier::all();

        // Example inventory data
        $inventoryItems = [
            ['item_name' => 'Dental Mirror', 'category' => 'tools', 'quantity_in_stock' => 50, 'price_per_unit' => 150.00],
            ['item_name' => 'Toothpaste', 'category' => 'hygiene', 'quantity_in_stock' => 200, 'price_per_unit' => 75.00],
            ['item_name' => 'Dental Chair', 'category' => 'tools', 'quantity_in_stock' => 5, 'price_per_unit' => 50000.00],
            ['item_name' => 'Mouthwash', 'category' => 'hygiene', 'quantity_in_stock' => 100, 'price_per_unit' => 120.00],
            ['item_name' => 'Dental Drill', 'category' => 'tools', 'quantity_in_stock' => 10, 'price_per_unit' => 25000.00],
        ];

        // Assign a random supplier to each inventory item
        foreach ($inventoryItems as $item) {
            Inventory::create(array_merge($item, [
                'supplier_id' => $suppliers->random()->id, // Assign a random supplier
            ]));
        }
    }
}
