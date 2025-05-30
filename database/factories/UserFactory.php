<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'phone' => $this->generateYemeniPhoneNumber(),
            'address' => $this->faker->streetAddress(),
            'status' => 'active',
            
        ];
    }

    protected function generateYemeniPhoneNumber(): string
    {
        // Yemen phone number formats:
        // Landline: +967 1 XXX XXX (Sana'a) or +967 X XXX XXX (other cities)
        // Mobile: +967 7X XXX XXX or +967 7XX XXX XXX
        
        $prefix = '+967';
        
        // 70% chance for mobile number, 30% for landline
        if ($this->faker->boolean(70)) {
            // Mobile number (7 followed by 1 or 2 digits)
            $mobilePrefix = '7' . $this->faker->randomElement([
                $this->faker->numberBetween(0, 9),       // 7X
                $this->faker->numberBetween(10, 99)      // 7XX
            ]);
            return sprintf(
                '%s %s %s %s',
                $prefix,
                $mobilePrefix,
                $this->faker->numberBetween(100, 999),
                $this->faker->numberBetween(100, 999)
            );
        }
        
        // Landline number
        $cityCode = $this->faker->randomElement([
            '1',    // Sana'a
            '2',    // Aden
            '3',    // Taiz
            '4',    // Hodeidah
            '5',    // Ibb
            '6',    // Dhamar
            // Add more city codes as needed
        ]);
        
        return sprintf(
            '%s %s %s %s',
            $prefix,
            $cityCode,
            $this->faker->numberBetween(100, 999),
            $this->faker->numberBetween(100, 999)
        );
    }

    

    // ... rest of your factory methods
}