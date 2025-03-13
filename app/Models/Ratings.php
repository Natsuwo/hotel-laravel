<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ratings extends Model
{
    protected $table = 'ratings';
    protected $fillable = [
        'guest_id',
        'room_type_id',
        'room_id',
        'booking_id',
        'rating',
        'comment',
    ];

    public function guest()
    {
        return $this->belongsTo(Guests::class, 'guest_id');
    }

    public function roomType()
    {
        return $this->belongsTo(RoomTypes::class, 'room_type_id');
    }

    public function room()
    {
        return $this->belongsTo(Rooms::class, 'room_id');
    }

    public function booking()
    {
        return $this->belongsTo(Reservations::class, 'booking_id');
    }
}
