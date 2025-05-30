<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'John Doe',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '+1122334455',
            'address' => '456 Main Street',
            'status'=>'active',
            // 'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'password' => Hash::make('password'),
            'phone' => '+1223344556',
            'address' => '789 Oak Avenue',
            'status'=>'active',
         
        ]);
    }
}
