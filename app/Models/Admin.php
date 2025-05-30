<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable  implements MustVerifyEmail
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function accidents()
    {
        return $this->hasMany(Accident::class, 'admin_id');
    }

    public function emergencyRequests()
    {
        return $this->hasMany(EmergencyRequest::class, 'admin_id');
    }
}