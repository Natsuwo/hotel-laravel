<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    protected $table = 'rooms';
    protected $fillable = [
        'room_number',
        'room_type_id',
        'floor_id',
        'status',
    ];
    public $timestamps = false;

    static function updateStatus($id, $status)
    {
        // status is available, occupied, maintenance
        if (!in_array($status, ['available', 'occupied', 'maintenance'])) {
            return false;
        }
        return self::where('id', $id)->update(['status' => $status]);
    }

    public function reservations()
    {
        return $this->hasOne(Reservations::class, 'room_id')->latest();
    }

    public function roomType()
    {
        return $this->belongsTo(RoomTypes::class, 'room_type_id');
    }

    public function floor()
    {
        return $this->belongsTo(Floors::class, 'floor_id');
    }

    public function housekeeping()
    {
        return $this->hasOne(Housekeeping::class, 'room_id');
    }
}
