<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example supplier data
        $suppliers = [
            ['name' => 'Dental Supplies Co.', 'email' => 'contact@dentalsupplies.com', 'phone' => '123-456-7890'],
            ['name' => 'Hygiene Essentials', 'email' => 'info@hygieneessentials.com', 'phone' => '987-654-3210'],
            ['name' => 'Tool Masters', 'email' => 'support@toolmasters.com', 'phone' => '456-789-1234'],
        ];

        // Insert suppliers into the database
        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
