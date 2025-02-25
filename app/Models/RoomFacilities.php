<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomFacilities extends Model
{
    protected $table = 'room_facilities';
    protected $fillable = [
        'room_type_id',
        'feature_id',
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomTypes::class, 'room_type_id');
    }

    public function feature()
    {
        return $this->belongsTo(Feature::class, 'feature_id');
    }
}
