<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'plate_number',
        'device_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function accidents()
    {
        return $this->hasMany(Accident::class);
    }
}