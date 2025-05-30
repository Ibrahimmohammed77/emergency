<?php

namespace Database\Seeders;

use App\Models\Accident;
use App\Models\MedicalCenter;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class AccidentSeeder extends Seeder
{
    public function run()
    {
        $users = User::pluck('id')->toArray();
        $vehicles = Vehicle::pluck('id')->toArray();
        $medicalCenters = MedicalCenter::pluck('id')->toArray();

        Accident::create([
            'user_id' => $users[0],
            'vehicle_id' => $vehicles[0],
            'medical_center_id' => $medicalCenters[0],
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'location_description' => 'Near Central Park',
            'status' => 'resolved',
            'admin_notes' => 'Initial report received',
            'medical_center_notes' => null,
            'responded_at' => null,
            'resolved_at' => null,
        ]);

        Accident::create([
            'user_id' => $users[1],
            'vehicle_id' => $vehicles[1],
            'medical_center_id' => $medicalCenters[1],
            'latitude' => 40.7215,
            'longitude' => -73.9875,
            'location_description' => 'Downtown intersection',
            'status' => 'pending',
            'admin_notes' => 'Ambulance dispatched',
            'medical_center_notes' => 'Preparing trauma team',
            'responded_at' => now(),
            'resolved_at' => null,
        ]);

        Accident::factory()->count(20)->create();
    }
}