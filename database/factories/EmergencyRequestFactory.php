<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmergencyRequestFactory extends Factory
{
    public function definition()
    {
        $statuses = ['pending', 'processing', 'resolved'];
        
        return [
            'user_id'=>User::factory(),
            'admin_id'=>'1',
            'message' => $this->faker->sentence(),
            'status' => $this->faker->randomElement($statuses),
            'response' => $this->faker->optional(0.7)->sentence(), // 70% chance of having a response
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }

    public function pending()
    {
        return $this->state([
            'status' => 'pending',
            'response' => null,
        ]);
    }

    public function processing()
    {
        return $this->state([
            'status' => 'processing',
            'response' => $this->faker->sentence(),
        ]);
    }

    public function resolved()
    {
        return $this->state([
            'status' => 'resolved',
            'response' => $this->faker->sentence(),
        ]);
    }
}