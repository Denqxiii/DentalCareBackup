<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Make sure your User model namespace is correct
use Illuminate\Support\Facades\Hash;

class DoctorUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Dr. John Doe',
            'email' => 'doctor@example.com',
            'password' => Hash::make('password123'), // Change this for production!
            'role' => 'doctor', // Make sure this matches your role column and logic
        ]);
    }
}
