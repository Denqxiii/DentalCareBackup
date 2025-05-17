<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Treatment; // Add this line

class TreatmentsTableSeeder extends Seeder
{
   public function run()
    {
        $treatments = [
            ['code' => 'CHK', 'name' => 'Dental Checkup', 'price' => 50.00, 'duration_minutes' => 30],
            ['code' => 'CLN', 'name' => 'Teeth Cleaning', 'price' => 80.00, 'duration_minutes' => 45],
            ['code' => 'FIL', 'name' => 'Tooth Filling', 'price' => 120.00, 'duration_minutes' => 60],
            ['code' => 'RCT', 'name' => 'Root Canal', 'price' => 300.00, 'duration_minutes' => 90],
            ['code' => 'CRW', 'name' => 'Dental Crown', 'price' => 500.00, 'duration_minutes' => 120],
        ];
        
        foreach ($treatments as $treatment) {
            Treatment::create($treatment);
        }
    }
}