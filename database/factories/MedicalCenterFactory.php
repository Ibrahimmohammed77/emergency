<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MedicalCenterFactory extends Factory
{
    public function definition()
    {
        $specializations = ['General', 'Trauma', 'Cardiac', 'Pediatric', 'Neurological'];
        
        return [
            'name' => $this->faker->company().' Medical Center',
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'specialization' => $this->faker->randomElement($specializations),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    public function active()
    {
        return $this->state([
            'status' => 'active',
        ]);
    }
}