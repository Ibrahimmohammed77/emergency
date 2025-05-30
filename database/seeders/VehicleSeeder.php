<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run()
    {
        $users = User::pluck('id')->toArray();

        Vehicle::create([
            'user_id' => $users[0],
            'type' => 'Sedan',
            'plate_number' => 'ABC123',
            'device_id' => 'DEV001',
        ]);

        Vehicle::create([
            'user_id' => $users[1],
            'type' => 'SUV',
            'plate_number' => 'XYZ789',
            'device_id' => 'DEV002',
        ]);

        Vehicle::factory()->count(10)->create();
    }
}