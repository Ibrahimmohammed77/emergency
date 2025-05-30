<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            MedicalCenterSeeder::class,
            UserSeeder::class, 
            VehicleSeeder::class,
            EmergencyRequestSeeder::class,
            AccidentSeeder::class,
        ]);
    }
}