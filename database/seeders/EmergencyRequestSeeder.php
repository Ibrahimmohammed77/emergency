<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\EmergencyRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmergencyRequestSeeder extends Seeder
{
    public function run()
    {
        // Create sample emergency requests
        $users = User::pluck('id');
        $admins = Admin::pluck('id');

        // Create specific test cases
        EmergencyRequest::create([
            'user_id' => $users->first(),
            'message' => 'I need immediate medical assistance!',
            'status' => 'pending',
            'response' => null,
            'admin_id' => null,
        ]);

        EmergencyRequest::create([
            'user_id' => $users->get(1),
            'message' => 'Car accident on Main Street, need ambulance',
            'status' => 'processing',
            'response' => 'Ambulance dispatched, ETA 10 minutes',
            'admin_id' => $admins->first(),
        ]);

        EmergencyRequest::create([
            'user_id' => $users->get(2),
            'message' => 'Fire in my building, need fire department',
            'status' => 'resolved',
            'response' => 'Fire department has handled the situation',
            'admin_id' => $admins->get(1),
        ]);

        // Create random emergency requests
        EmergencyRequest::factory()
            ->count(20)
            ->state(function (array $attributes) use ($users, $admins) {
                return [
                    'user_id' => $users->random(),
                    'admin_id' => rand(0, 0) ? $admins->random() : null,
                ];
            })
            ->create();
    }
}