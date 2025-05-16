<?php

namespace Database\Seeders;

use App\Models\Expense;
use Illuminate\Database\Seeder;

class ExpensesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = ['Equipment', 'Staff Salary', 'Dental Supplies', 'Utilities', 'Rent'];
        
        foreach (range(1, 50) as $i) {
            Expense::create([
                'date' => now()->subDays(rand(1, 60)),
                'category' => $categories[array_rand($categories)],
                'description' => 'Expense #'.$i,
                'amount' => rand(100, 5000),
                'payment_method' => ['Cash', 'Check', 'Credit Card'][rand(0, 2)],
                'reference' => 'EXP-'.rand(1000, 9999)
            ]);
        }
    }
}