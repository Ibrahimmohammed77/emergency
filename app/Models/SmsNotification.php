<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'accident_id',
        'message',
        'status',
        'recipient_number',
        'sent_at'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function accident()
    {
        return $this->belongsTo(Accident::class);
    }
}