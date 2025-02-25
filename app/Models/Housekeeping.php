<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Housekeeping extends Model
{
    protected $table = 'housekeeping';

    protected $fillable = [
        'room_id',
        'booking_id',
        'status',
        'notes',
        'priority'
    ];

    public function room()
    {
        return $this->belongsTo(Rooms::class, 'room_id');
    }

    public function booking()
    {
        return $this->belongsTo(Reservations::class, 'booking_id');
    }
}
