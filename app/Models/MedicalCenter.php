<?php

namespace App\Models;

use App\Notifications\CustomResetPasswordNotification;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class MedicalCenter extends Authenticatable  implements MustVerifyEmail
{
    use HasFactory, Notifiable,CanResetPassword;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'latitude',
        'longitude',
        'specialization',
        'status',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function accidents()
    {
        return $this->hasMany(Accident::class);
    }
   public function sendPasswordResetNotification($token)
{
    $this->notify(new CustomResetPasswordNotification($token, 'medical_center'));
}

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }
}
