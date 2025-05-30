<?php

namespace Database\Seeders;

use App\Models\MedicalCenter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MedicalCenterSeeder extends Seeder
{
    public function run()
    {
        MedicalCenter::create([
            'name' => 'City General Hospital',
            'email' => 'hospital@gmail.com',
            'phone' => '+1234567890',
            'address' => '123 Main Street, City',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'specialization' => 'General Emergency',
            'status' => 'active',
            'password' => Hash::make('password'),
        ]);

        MedicalCenter::create([
            'name' => 'Trauma Center',
            'email' => 'trauma@example.com',
            'phone' => '+1987654321',
            'address' => '456 Oak Avenue, City',
            'latitude' => 40.7215,
            'longitude' => -73.9875,
            'specialization' => 'Trauma Care',
            'status' => 'active',
            'password' => Hash::make('password'),
        ]);

        MedicalCenter::factory()->count(5)->create();
    }
}