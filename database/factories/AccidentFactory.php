<?php

namespace Database\Factories;

use App\Models\MedicalCenter;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccidentFactory extends Factory
{
    public function definition()
    {
        $statuses = ['pending', 'processing', 'resolved'];
        $status = $this->faker->randomElement($statuses);
        
        // Coordinates for Yemen (approximate center point)
        $latitude = $this->faker->latitude(12, 19);
        $longitude = $this->faker->longitude(42, 54);
        
        return [
            'user_id' => User::factory(),
            'vehicle_id' => Vehicle::factory(),
            'medical_center_id' => MedicalCenter::factory(),
            'latitude' => $latitude,
            'longitude' => $longitude,
            'location_description' => $this->faker->address,
            'status' => $status,
            'admin_notes' => $this->faker->optional(0.6)->paragraph,
            'medical_center_notes' => $this->faker->optional(0.5)->paragraph,
            'responded_at' => $status !== 'pending' ? $this->faker->dateTimeThisMonth : null,
            'resolved_at' => $status === 'resolved' ? $this->faker->dateTimeThisMonth : null,
        ];
    }

    public function pending()
    {
        return $this->state([
            'status' => 'pending',
            'responded_at' => null,
            'resolved_at' => null,
        ]);
    }

    public function processing()
    {
        return $this->state([
            'status' => 'processing',
            'responded_at' => now(),
            'resolved_at' => null,
        ]);
    }

    public function resolved()
    {
        return $this->state([
            'status' => 'resolved',
            'responded_at' => $this->faker->dateTimeThisMonth,
            'resolved_at' => now(),
        ]);
    }

    public function withUser(User $user)
    {
        return $this->state([
            'user_id' => $user->id,
        ]);
    }

    public function withVehicle(Vehicle $vehicle)
    {
        return $this->state([
            'vehicle_id' => $vehicle->id,
        ]);
    }

    public function withMedicalCenter(MedicalCenter $medicalCenter)
    {
        return $this->state([
            'medical_center_id' => $medicalCenter->id,
        ]);
    }

    public function withCoordinates(float $latitude, float $longitude)
    {
        return $this->state([
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);
    }
}