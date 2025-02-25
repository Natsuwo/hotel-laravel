<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomGalleries extends Model
{
    public $timestamps = false;
    protected $table = 'room_galleries';
    protected $fillable = [
        'room_type_id',
        'gallery_id',
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomTypes::class, 'room_type_id');
    }

    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id');
    }
}
