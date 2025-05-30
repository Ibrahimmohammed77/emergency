<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    public function definition()
    {
        $types = ['Sedan', 'SUV', 'Truck', 'Motorcycle', 'Van'];
        
        return [
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement($types),
            'plate_number' => strtoupper($this->faker->bothify('???###')),
            'device_id' => 'DEV'.$this->faker->unique()->numerify('#####'),
        ];
    }

    public function forUser($user)
    {
        return $this->state([
            'user_id' => $user->id,
        ]);
    }
}