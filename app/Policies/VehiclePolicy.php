<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehiclePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view the vehicle
     */
    public function view(User $user, Vehicle $vehicle): bool
    {
        return $user->id === $vehicle->user_id;
    }

    /**
     * Determine if the user can update the vehicle
     */
    public function update(User $user, Vehicle $vehicle): bool
    {
        return $user->id === $vehicle->user_id;
    }

    /**
     * Determine if the user can delete the vehicle
     */
    public function delete(User $user, Vehicle $vehicle): bool
    {
        return $user->id === $vehicle->user_id;
    }
}