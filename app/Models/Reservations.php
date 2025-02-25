<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{
    protected $table = 'reservations';
    protected $fillable = [
        'room_id',
        'booking_id',
        'guest_id',
        'check_in',
        'check_out',
        'duration',
        'adults',
        'children',
        'notes',
        'status', // 0 = pending, 1 = approved, 2 = rejected
    ];

    public function guest()
    {
        return $this->belongsTo(Guests::class, 'guest_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoices::class, 'booking_id');
    }

    public function room()
    {
        return $this->belongsTo(Rooms::class, 'room_id');
    }

    static function generateBookingId()
    {
        $year = date('y');
        $lastReservation = self::orderBy('id', 'desc')->first();
        $lastId = $lastReservation ? intval(substr($lastReservation->booking_id, 4)) : 0;
        $newId = str_pad($lastId + 1, 6, '0', STR_PAD_LEFT);
        $bookingId = $year . '-B' . $newId;
        return $bookingId;
    }
}
